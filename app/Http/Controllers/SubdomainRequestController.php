<?php

namespace App\Http\Controllers;

use App\Helpers\SubdomainHelper;
use App\Models\Pse;
use App\Models\SubdomainRequest;
use App\Http\Controllers\PseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubdomainRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // list subdomain requests yang dimiliki user
    public function index(Request $request)
    {
        // base query
        $query = SubdomainRequest::with(['pse', 'user'])
        ->where('subdomain_requests.user_id', Auth::id());

        // Sanitasi: escape wildcard (% _) agar tidak dieksploitasi untuk query abuse
        if ($request->filled('search')) {
            $query->where('subdomain_requests.subdomain_name', 'like', '%' . escapeLike($request->search) . '%');
        }

        // Status Filter
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('subdomain_requests.status', $request->status);
        }

        // Sorting — whitelist: hanya kolom terdaftar yang diizinkan, mencegah SQL injection via orderBy
        $sortBy = $request->input('sort_by', 'created_at');
        // Normalisasi: hanya 'asc'/'desc' yang diterima, string liar di-fallback ke default
        $sortDir = normalizeSortDirection($request->input('sort_dir'), 'desc');
        $allowedSortFields = ['system_name', 'request_type', 'created_at'];

        if ($sortBy === 'system_name') {
            $query->join('pses', 'subdomain_requests.pse_id', '=', 'pses.id')
                ->select('subdomain_requests.*')
                ->orderBy('pses.system_name', $sortDir);
        } elseif (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy('subdomain_requests.' . $sortBy, $sortDir);
        } else {
            // Fallback: sort_by tidak valid dikembalikan ke default aman
            $query->orderBy('subdomain_requests.created_at', 'desc');
        }

        // pagination
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        $subdomains = $query->paginate($perPage);

        // append search & filter query to pagination
        $subdomains->appends([
            'search' => $request->search,
            'per_page' => $request->per_page,
            'status' => $request->status,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
        ]);

        // return view
        return view('subdomain.index', compact('subdomains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pses = Pse::where('user_id', Auth::id())
        ->where('status', 'approved')
        ->get();

        $requestTypes = SubdomainRequest::getRequestTypes();

        return view('subdomain.create', compact('pses', 'requestTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Normalisasi subdomain_name sebelum validasi (Strip suffix)
        if ($request->has('subdomain_name')) {
            $request->merge([
                'subdomain_name' => SubdomainHelper::normalize($request->input('subdomain_name'))
            ]);
        }

        // validasi request
        $validated = $request->validate([
            'pse_id' => 'required|exists:pses,id',
            'request_type' => 'required|in:baru,perpanjangan,ubah,hapus',
            // Validasi subdomain: regex hostname, max 63 karakter, mencegah input berbahaya
            'subdomain_name' => ['required', 'string', 'max:63', 'regex:/^[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?$/'],
            'surat_permohonan' => ['nullable', 'file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:5120'], // 5MB
        ]);

        // Validasi maksimal 2 draft per PSE
        $draftCount = SubdomainRequest::where('user_id', Auth::id())
            ->where('pse_id', $validated['pse_id'])
            ->where('status', 'draft')
            ->count();

        if ($draftCount >= 2) {
            return back()->with('error', __('messages.subdomain.limit_draft'))
                         ->withInput();
        }

        // Validasi subdomain availability (DRY & Normalized)
        $availability = SubdomainRequest::checkAvailability($validated['subdomain_name'], $validated['request_type']);
        if (!$availability['available']) {
            return back()->with('error', $availability['message'])->withInput();
        }

        //validasi PSE miliki user
        $pse = Pse::where('id', $validated['pse_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->firstOrFail();


        DB::transaction(function () use ($request, $pse, $validated) {
            // simpan request subdomain baru
            $subdomainRequest = SubdomainRequest::create([
                'user_id' => Auth::id(),
                'pse_id' => $validated['pse_id'],
                'request_type' => $validated['request_type'],
                'subdomain_name' => strtolower($validated['subdomain_name']),
                'status' => 'draft',
            ]);

            // handle file upload untuk surat permohonan
            if ($request->hasFile('surat_permohonan')) {
                $file = $request->file('surat_permohonan');

                // UUID untuk storage (security)
                $uuidFileName = Str::uuid() . '.pdf';

                // Generate descriptive filename untuk download
                $descriptiveName = sprintf(
                    '%s_surat_permohonan_subdomain_%s_%s.pdf',
                    format_filename_timestamp(),
                    $subdomainRequest->request_type,
                    Str::slug($pse->system_name)
                );

                // Store dengan UUID di private storage
                $filePath = $file->storeAs('documents/subdomain', $uuidFileName, 'private');

                // create document record dengan polymorphic relationship
                $subdomainRequest->document()->create([
                    'original_name' => $descriptiveName,
                    'file_path' => $filePath,
                ]);
            }
        });

        // redirect ke index
        return redirect()->route('subdomain.index')->with('success', __('messages.subdomain.draft_stored'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SubdomainRequest $subdomain)
    {
        $this->authorize('view', $subdomain);

        $subdomain->load(['pse.subdomainRequests.document', 'user', 'verificationHistories.user']);

        return view('subdomain.show', compact('subdomain'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubdomainRequest $subdomain)
    {
        $this->authorize('update', $subdomain);

        // Ambil PSE yang sudah disetujui ATAU PSE yang sedang terhubung saat ini
        $pses = Pse::where('user_id', Auth::id())
            ->where(function($query) use ($subdomain) {
                $query->where('status', 'approved')
                      ->orWhere('id', $subdomain->pse_id);
            })
            ->get();

        $requestTypes = SubdomainRequest::getRequestTypes();
        $backUrl = url()->previous();

        return view('subdomain.edit', compact('subdomain', 'pses', 'requestTypes', 'backUrl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubdomainRequest $subdomain)
    {
        $this->authorize('update', $subdomain);

        // Normalisasi subdomain_name sebelum validasi (Strip suffix)
        if ($request->has('subdomain_name')) {
            $request->merge([
                'subdomain_name' => SubdomainHelper::normalize($request->input('subdomain_name'))
            ]);
        }

        $validated = $request->validate([
            'pse_id' => 'required|exists:pses,id',
            'request_type' => 'required|in:baru,perpanjangan,ubah,hapus',
            // Enforce strict hostname label format: max 63 chars, a-z0-9, no start/end dash, no dots
            'subdomain_name' => ['required', 'string', 'max:63', 'regex:/^[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?$/'],
            'surat_permohonan' => ['nullable', 'file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:5120'], // 5MB
        ]);

        // Validasi subdomain availability (DRY & Normalized)
        $availability = SubdomainRequest::checkAvailability($validated['subdomain_name'], $validated['request_type'], $subdomain->id);
        if (!$availability['available']) {
            return back()->with('error', $availability['message'])->withInput();
        }

        // Validasi PSE milik user (Harus approved ATAU PSE yang sama jika sedang edit draf)
        Pse::where('id', $validated['pse_id'])
            ->where('user_id', Auth::id())
            ->where(function($query) use ($subdomain) {
                $query->where('status', 'approved')
                      ->orWhere('id', $subdomain->pse_id);
            })
            ->firstOrFail();


        DB::transaction(function () use ($request, $subdomain, $validated) {
            $subdomain->update([
                'pse_id' => $validated['pse_id'],
                'request_type' => $validated['request_type'],
                'subdomain_name' => strtolower($validated['subdomain_name']),
            ]);

            // handle file upload untuk surat permohonan
            if ($request->hasFile('surat_permohonan')) {
                // delete old file if exists
                if ($subdomain->document) {
                    Storage::disk('private')->delete($subdomain->document->file_path);
                    $subdomain->document->delete();
                }

                // store new file
                $file = $request->file('surat_permohonan');

                // UUID untuk storage (security)
                $uuidFileName = Str::uuid() . '.pdf';

                // Generate descriptive filename untuk download
                $descriptiveName = sprintf(
                    '%s_surat_permohonan_subdomain_%s_%s.pdf',
                    format_filename_timestamp(),
                    $subdomain->request_type,
                    Str::slug($subdomain->pse->system_name)
                );

                // Store dengan UUID di private storage
                $filePath = $file->storeAs('documents/subdomain', $uuidFileName, 'private');

                // create document record dengan polymorphic relationship
                $subdomain->document()->create([
                    'original_name' => $descriptiveName,
                    'file_path' => $filePath,
                ]);
            }
        });

        return redirect()->route('subdomain.index')->with('success', __('messages.subdomain.draft_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubdomainRequest $subdomain)
    {
        $this->authorize('delete', $subdomain);

        // Proteksi Data Single Flow
        if (in_array($subdomain->pse->status, ['draft', 'rejected'])) {
            return redirect()
                ->route('pse.edit', $subdomain->pse)
                ->with('error', __('messages.error.single_flow_protection'));
        }

        // Store data for logging before deletion
        $subdomainData = [
            'id' => $subdomain->id,
            'uuid' => $subdomain->uuid,
            'subdomain_name' => $subdomain->subdomain_name,
            'request_type' => $subdomain->request_type,
            'status' => $subdomain->status,
            'pse_system_name' => $subdomain->pse->system_name,
        ];

        $subdomain->delete();

        // Log critical action
        Log::warning('Subdomain request deleted', [
            'action' => 'delete',
            'resource_type' => 'subdomain',
            'resource_id' => $subdomainData['id'],
            'resource_uuid' => $subdomainData['uuid'],
            'subdomain_name' => $subdomainData['subdomain_name'],
            'request_type' => $subdomainData['request_type'],
            'status' => $subdomainData['status'],
            'pse_system_name' => $subdomainData['pse_system_name'],
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'user_role' => auth()->user()->role->role_name,
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('subdomain.index')->with('success', __('messages.subdomain.draft_deleted'));
    }

    public function submit(SubdomainRequest $subdomain)
    {
        $this->authorize('submit', $subdomain);

        if (!in_array($subdomain->status, ['draft', 'rejected'])) {
            return back()->with('error', __('messages.subdomain.submit_error_status', ['status' => $subdomain->status]))
                         ->withInput();
        }

        // Cek bila PSE induk masih draft atau rejected (Single Flow)
        if (in_array($subdomain->pse->status, ['draft', 'rejected'])) {
            // Forward/delegate ke PseController untuk mengajukan serentak secara bilateral
            return app(PseController::class)->submit($subdomain->pse);
        }

        // validasi dokumen wajib ada sebelum submit
        if (!$subdomain->document) {
            return redirect()
                ->route('subdomain.edit', $subdomain)
                ->with('error', __('messages.error.upload_required'));
        }

        // Validasi subdomain availability (DRY & Normalized)
        // Kita gunakan $subdomain->subdomain_name yang sudah ada suffix dari DB/Model
        // normalizeSubdomainName akan handle string yang sudah ada suffix sekalipun
        $availability = SubdomainRequest::checkAvailability($subdomain->subdomain_name, $subdomain->request_type, $subdomain->id);
        if (!$availability['available']) {
            return back()->with('error', $availability['message'])->withInput();
        }

        // Jika PSE sudah approved (alur pengajuan mandiri)
        // Pastikan PSE milik user yang sedang login
        if ($subdomain->pse->user_id !== Auth::id() || $subdomain->pse->status !== 'approved') {
            abort(403, 'Unauthorized action.');
        }

        $subdomain->update([
            'status' => 'pending_1',
        ]);

        return redirect()->route('subdomain.index')->with('success', __('messages.subdomain.submit_success'));
    }
}
