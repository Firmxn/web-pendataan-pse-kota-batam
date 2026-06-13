<?php

namespace App\Http\Controllers;

use App\Models\HostingRequest;
use App\Models\Pse;
use App\Http\Controllers\PseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HostingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // query base
        $query = HostingRequest::with(['pse', 'user'])
            ->where('hosting_requests.user_id', Auth::id());

        // Sanitasi: escape wildcard (% _) agar tidak dieksploitasi untuk query abuse
        if ($request->filled('search')) {
            $search = escapeLike($request->search);
            $query->whereHas('pse', function ($q) use ($search) {
                $q->where('system_name', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('hosting_requests.status', $request->status);
        }

        // Sorting — whitelist: hanya kolom terdaftar yang diizinkan, mencegah SQL injection via orderBy
        $sortBy = $request->input('sort_by', 'created_at');
        // Normalisasi: hanya 'asc'/'desc' yang diterima, string liar di-fallback ke default
        $sortDir = normalizeSortDirection($request->input('sort_dir'), 'desc');
        $allowedSortFields = ['system_name', 'hosting_type', 'request_type', 'created_at'];

        if ($sortBy === 'system_name') {
            $query->join('pses', 'hosting_requests.pse_id', '=', 'pses.id')
                ->select('hosting_requests.*')
                ->orderBy('pses.system_name', $sortDir);
        } elseif (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy('hosting_requests.' . $sortBy, $sortDir);
        } else {
            // Fallback: sort_by tidak valid dikembalikan ke default aman
            $query->orderBy('hosting_requests.created_at', 'desc');
        }

        // pagination
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        $hostings = $query->paginate($perPage);

        // append search & filter query to pagination
        $hostings->appends([
            'search' => $request->search,
            'per_page' => $request->per_page,
            'status' => $request->status,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
        ]);

        // Hitung jumlah draft untuk tooltip
        $draftCount = HostingRequest::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->count();

        // return view
        return view('hosting.index', compact('hostings', 'draftCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // query pse
        $pses = Pse::where('user_id', Auth::id())
        ->where('status', 'approved')
        ->get();

        $requestTypes = HostingRequest::getRequestTypes();
        $hostingTypes = HostingRequest::getHostingTypes();
        $cpuCores = HostingRequest::getCpuCores();
        $ramCapacities = HostingRequest::getRamCapacities();
        $storageCapacities = HostingRequest::getStorageCapacities();
        $bandwidthCapacities = HostingRequest::getBandwidthCapacities();

        return view('hosting.create', compact(
            'pses', 
            'requestTypes', 
            'hostingTypes', 
            'cpuCores', 
            'ramCapacities', 
            'storageCapacities', 
            'bandwidthCapacities'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi request
        $validated = $request->validate([
            'pse_id' => 'required|exists:pses,id',
            'request_type' => 'required|in:baru,ubah,perpanjangan,hapus',
            'hosting_type' => 'required|in:shared,vps,dedicated,cloud',
            'cpu_cores' => 'required|integer|in:1,2,4,8,16,32',
            'ram_capacity' => 'required|integer|in:1,2,4,8,16,32,64',
            'storage_capacity' => 'required|integer|in:10,20,50,100,200,500,1000',
            'bandwidth_capacity' => 'required|integer|in:100,500,1000,5000',
            'notes' => ['nullable', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
            'surat_permohonan' => ['nullable', 'file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:5120'], // 5MB
        ]);

        // validasi draft hosting (maksimal 2 draft per user)
        $draftCount = HostingRequest::where('user_id', Auth::id())
        ->where('status', 'draft')
        ->count();

        if ($draftCount >= 2) {
            return redirect()->back()->with('error', __('messages.hosting.limit_draft'));
        }

        // validasi user miliki pse
        $pse = Pse::where('id', $validated['pse_id'])
        ->where('user_id', Auth::id())
        ->where('status', 'approved')
        ->firstOrFail();

        // Validasi Logika Bisnis
        $existingHosting = HostingRequest::where('pse_id', $validated['pse_id'])
            ->where('status', 'approved')
            ->where('request_type', '!=', 'hapus')
            ->latest()
            ->first();

        if ($validated['request_type'] === 'baru') {
            if ($existingHosting) {
                return back()->with('error', __('messages.hosting.exists_error'))->withInput();
            }
        } else {
            // Untuk ubah/perpanjangan/hapus, HARUS ada hosting aktif sebelumnya
            if (!$existingHosting) {
                return back()->with('error', __('messages.hosting.not_exists_error'))->withInput();
            }
        }


        DB::transaction(function () use ($request, $validated) {
            // simpan request hosting baru
            $hostingRequest = HostingRequest::create([
                'pse_id' => $validated['pse_id'],
                'user_id' => Auth::id(),
                'request_type' => $validated['request_type'],
                'hosting_type' => $validated['hosting_type'],
                'cpu_cores' => $validated['cpu_cores'],
                'ram_capacity' => $validated['ram_capacity'],
                'storage_capacity' => $validated['storage_capacity'],
                'bandwidth_capacity' => $validated['bandwidth_capacity'],
                'notes' => $validated['notes'],
                'status' => 'draft',
            ]);

            // handle file upload untuk surat permohonan
            if ($request->hasFile('surat_permohonan')) {
                $file = $request->file('surat_permohonan');

                // UUID sebagai nama file storage: mencegah path traversal dan prediksi URL
                $uuidFileName = Str::uuid() . '.pdf';

                // Generate descriptive filename untuk download
                $descriptiveName = sprintf(
                    '%s_surat_permohonan_hosting_%s_%s.pdf',
                    format_filename_timestamp(),
                    $hostingRequest->request_type,
                    Str::slug($hostingRequest->pse->system_name)
                );

                // Simpan di private storage: file tidak bisa diakses langsung via URL publik
                $filePath = $file->storeAs('documents/hosting', $uuidFileName, 'private');

                // create document record dengan polymorphic relationship
                $hostingRequest->document()->create([
                    'original_name' => $descriptiveName,
                    'file_path' => $filePath,
                ]);
            }
        });

        // redirect ke index
        return redirect()->route('hosting.index')->with('success', __('messages.hosting.draft_stored'));
    }

    /**
     * Display the specified resource.
     */
    public function show(HostingRequest $hosting)
    {
        $this->authorize('view', $hosting);

        $hosting->load(['pse.subdomainRequests.document', 'user', 'verificationHistories.user']);

        return view('hosting.show', compact('hosting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HostingRequest $hosting)
    {
        $this->authorize('update', $hosting);

        // Ambil PSE yang sudah disetujui ATAU PSE yang sedang terhubung saat ini
        $pses = Pse::where('user_id', Auth::id())
            ->where(function($query) use ($hosting) {
                $query->where('status', 'approved')
                      ->orWhere('id', $hosting->pse_id);
            })
            ->get();

        $requestTypes = HostingRequest::getRequestTypes();
        $hostingTypes = HostingRequest::getHostingTypes();
        $cpuCores = HostingRequest::getCpuCores();
        $ramCapacities = HostingRequest::getRamCapacities();
        $storageCapacities = HostingRequest::getStorageCapacities();
        $bandwidthCapacities = HostingRequest::getBandwidthCapacities();
        $backUrl = url()->previous();

        return view('hosting.edit', compact(
            'hosting', 
            'pses', 
            'requestTypes', 
            'hostingTypes', 
            'cpuCores', 
            'ramCapacities', 
            'storageCapacities', 
            'bandwidthCapacities', 
            'backUrl'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HostingRequest $hosting)
    {
        $this->authorize('update', $hosting);

        $validated = $request->validate([
            'pse_id' => 'required|exists:pses,id',
            'request_type' => 'required|in:baru,ubah,perpanjangan,hapus',
            'hosting_type' => 'required|in:shared,vps,dedicated,cloud',
            'cpu_cores' => 'required|integer|in:1,2,4,8,16,32',
            'ram_capacity' => 'required|integer|in:1,2,4,8,16,32,64',
            'storage_capacity' => 'required|integer|in:10,20,50,100,200,500,1000',
            'bandwidth_capacity' => 'required|integer|in:100,500,1000,5000',
            'notes' => ['nullable', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
            'surat_permohonan' => ['nullable', 'file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:5120'], // 5MB
        ]);

        // Validasi PSE milik user (Harus approved ATAU PSE yang sama jika sedang edit draf)
        $pse = Pse::where('id', $validated['pse_id'])
            ->where('user_id', Auth::id())
            ->where(function($query) use ($hosting) {
                $query->where('status', 'approved')
                      ->orWhere('id', $hosting->pse_id);
            })
            ->firstOrFail();

        // Validasi Logika Bisnis (sama dengan store)
        $existingHosting = HostingRequest::where('pse_id', $validated['pse_id'])
            ->where('status', 'approved')
            ->where('request_type', '!=', 'hapus')
            ->latest()
            ->first();

        if ($validated['request_type'] === 'baru') {
            if ($existingHosting) {
                return back()->with('error', __('messages.hosting.exists_error'))->withInput();
            }
        } else {
            if (!$existingHosting) {
                return back()->with('error', __('messages.hosting.not_exists_error'))->withInput();
            }
        }


        DB::transaction(function () use ($request, $hosting, $validated) {
            $hosting->update([
                'pse_id' => $validated['pse_id'],
                'request_type' => $validated['request_type'],
                'hosting_type' => $validated['hosting_type'],
                'cpu_cores' => $validated['cpu_cores'],
                'ram_capacity' => $validated['ram_capacity'],
                'storage_capacity' => $validated['storage_capacity'],
                'bandwidth_capacity' => $validated['bandwidth_capacity'],
                'notes' => $validated['notes'],
            ]);

            // handle file upload untuk surat permohonan
            if ($request->hasFile('surat_permohonan')) {
                // delete old file if exists
                if ($hosting->document) {
                    Storage::disk('private')->delete($hosting->document->file_path);
                    $hosting->document->delete();
                }

                // store new file
                $file = $request->file('surat_permohonan');

                // UUID untuk storage (security)
                $uuidFileName = Str::uuid() . '.pdf';

                // Generate descriptive filename untuk download
                $descriptiveName = sprintf(
                    '%s_surat_permohonan_hosting_%s_%s.pdf',
                    format_filename_timestamp(),
                    $hosting->request_type,
                    Str::slug($hosting->pse->system_name)
                );

                // Store dengan UUID di private storage
                $filePath = $file->storeAs('documents/hosting', $uuidFileName, 'private');

                // create document record dengan polymorphic relationship
                $hosting->document()->create([
                    'original_name' => $descriptiveName,
                    'file_path' => $filePath,
                ]);
            }
        });


        return redirect()->route('hosting.index')->with('success', __('messages.hosting.draft_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HostingRequest $hosting)
    {
        $this->authorize('delete', $hosting);

        // Proteksi Data Single Flow
        if (in_array($hosting->pse->status, ['draft', 'rejected'])) {
            return redirect()
                ->route('pse.edit', $hosting->pse)
                ->with('error', __('messages.error.single_flow_protection'));
        }

        // Store data for logging before deletion
        $hostingData = [
            'id' => $hosting->id,
            'uuid' => $hosting->uuid,
            'request_type' => $hosting->request_type,
            'status' => $hosting->status,
            'pse_system_name' => $hosting->pse->system_name,
        ];

        $hosting->delete();

        // Log critical action
        Log::warning('Hosting request deleted', [
            'action' => 'delete',
            'resource_type' => 'hosting',
            'resource_id' => $hostingData['id'],
            'resource_uuid' => $hostingData['uuid'],
            'request_type' => $hostingData['request_type'],
            'status' => $hostingData['status'],
            'pse_system_name' => $hostingData['pse_system_name'],
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'user_role' => auth()->user()->role->role_name,
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('hosting.index')->with('success', __('messages.hosting.draft_deleted'));
    }

    public function submit(HostingRequest $hosting)
    {
        $this->authorize('submit', $hosting);

        // Cek bila PSE induk masih draft atau rejected (Single Flow)
        if (in_array($hosting->pse->status, ['draft', 'rejected'])) {
            // Forward/delegate ke PseController untuk mengajukan serentak secara bilateral
            return app(PseController::class)->submit($hosting->pse);
        }

        // validasi dokumen wajib ada sebelum submit
        if (!$hosting->document) {
            return redirect()
                ->route('hosting.edit', $hosting)
                ->with('error', __('messages.error.upload_required'));
        }

        // Jika PSE sudah approved (alur pengajuan mandiri)
        if ($hosting->pse->user_id !== Auth::id() || $hosting->pse->status !== 'approved') {
            abort(403, 'Unauthorized action.');
        }

        // Re-validate business logic before submit
        $existingHosting = HostingRequest::where('pse_id', $hosting->pse_id)
            ->where('status', 'approved')
            ->where('request_type', '!=', 'hapus')
            ->latest()
            ->first();

        if ($hosting->request_type === 'baru') {
            if ($existingHosting) {
                return back()->with('error', __('messages.hosting.exists_active_error'));
            }
        } else {
            if (!$existingHosting) {
                return back()->with('error', __('messages.hosting.not_exists_active_error'));
            }
        }

        $hosting->update(['status' => 'pending_1']);

        return redirect()->route('hosting.index')->with('success', __('messages.hosting.submit_success'));
    }
}
