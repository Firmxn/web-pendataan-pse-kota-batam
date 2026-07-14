<?php

namespace App\Http\Controllers;

use App\Helpers\SubdomainHelper;
use App\Models\HostingRequest;
use App\Models\Pse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //  Base Query
        $query = Pse::with(['user', 'opd', 'subdomainRequests'])
            ->where('user_id', Auth::id());

        //  Sanitasi: escape wildcard (% _) agar tidak dieksploitasi untuk query abuse
        if ($request->filled('search')) {
            $query->where('system_name', 'like', '%' . escapeLike($request->search) . '%');
        }

        // Status Filter
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Sorting — whitelist: hanya kolom terdaftar yang diizinkan, mencegah SQL injection via orderBy
        $sortBy = $request->input('sort_by', 'created_at');
        // Normalisasi: hanya 'asc'/'desc' yang diterima, string liar di-fallback ke default
        $sortDir = normalizeSortDirection($request->input('sort_dir'), 'desc');
        $allowedSortFields = ['system_name', 'sector', 'created_at'];

        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortDir);
        } else {
            // Fallback: sort_by tidak valid dikembalikan ke default aman
            $query->orderBy('created_at', 'desc');
        }

        //  Pagination
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        $pses = $query->paginate($perPage);

        //  Append search & filter query to pagination
        $pses->appends([
            'search' => $request->search,
            'per_page' => $request->per_page,
            'status' => $request->status,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
        ]);

        //  Hitung jumlah draft untuk indicator
        $draftCount = Pse::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->count();

        //  Return view
        return view('pse.index', compact('pses', 'draftCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Siapkan metadata untuk form
        $storageLocations = Pse::getStorageLocations();
        $sectors = Pse::getSectors();
        $riskCategories = Pse::getRiskCategories();
        $dataClassifications = Pse::getDataClassifications();

        $hostingMetadata = [
            'request_types'        => HostingRequest::getRequestTypes(),
            'hosting_types'        => HostingRequest::getHostingTypes(),
            'cpu_cores'            => HostingRequest::getCpuCores(),
            'ram_capacities'       => HostingRequest::getRamCapacities(),
            'storage_capacities'   => HostingRequest::getStorageCapacities(),
            'bandwidth_capacities' => HostingRequest::getBandwidthCapacities(),
        ];

        return view('pse.create', compact('storageLocations', 'sectors', 'riskCategories', 'dataClassifications', 'hostingMetadata'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->normalizeSubdomainInputs($request);
        $this->normalizePicPhoneInput($request);

        $validatedData = $request->validate([
            'system_name' => ['required', 'string', 'max:150', 'unique:pses,system_name', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)]+$/u'],
            'sector' => ['required', 'string', 'in:' . implode(',', array_keys(Pse::getSectors()))],
            'pic_name' => ['required', 'string', 'max:150', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)]+$/u'],
            'pic_phone' => ['required', 'string', 'max:20', 'regex:/^62[0-9]{9,15}$/'],
            'pic_email' => ['required', 'email', 'max:150'],
            'subdomains' => ['required', 'array', 'min:1'], // Standard array from chips-input
            'subdomains.*' => $this->subdomainValidationRules(),
            'description' => ['nullable', 'string', 'max:3000', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
            'risk_category' => ['required', 'string', 'in:rendah,sedang,tinggi'],
            'data_classification' => ['required', 'string', 'in:publik,internal,rahasia,sangat rahasia'],
            'private_data_info' => ['nullable', 'string', 'max:2000', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
            'storage_location' => ['required', 'string', 'in:' . implode(',', array_keys(Pse::getStorageLocations()))],

            // Validasi Kondisional Hosting
            'hosting_request_type' => ['required_if:storage_location,aplikasi', 'string', 'in:' . implode(',', array_keys(HostingRequest::getRequestTypes()))],
            'hosting_type' => ['required_if:storage_location,aplikasi', 'string', 'in:' . implode(',', array_keys(HostingRequest::getHostingTypes()))],
            'cpu_cores' => ['required_if:storage_location,aplikasi', 'integer', 'in:' . implode(',', HostingRequest::getCpuCores())],
            'ram_capacity' => ['required_if:storage_location,aplikasi', 'integer', 'in:' . implode(',', HostingRequest::getRamCapacities())],
            'storage_capacity' => ['required_if:storage_location,aplikasi', 'integer', 'in:' . implode(',', HostingRequest::getStorageCapacities())],
            'bandwidth_capacity' => ['required_if:storage_location,aplikasi', 'integer', 'in:' . implode(',', HostingRequest::getBandwidthCapacities())],
            'hosting_notes' => ['nullable', 'string', 'max:2000'],
            'surat_subdomain' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // Boleh kosong saat create, diwajibkan saat submit (Single Flow)
        ], [
            'pic_phone.regex' => 'Format nomor telepon PIC harus berupa nomor telepon valid yang diawali dengan kode negara 62 (contoh: 628123456789 atau 08123456789).',
        ]);

        // Validasi ketersediaan subdomain
        foreach ($validatedData['subdomains'] as $subdomainName) {
            $availability = \App\Models\SubdomainRequest::checkAvailability($subdomainName, 'baru');
            if (!$availability['available']) {
                return back()->with('error', $availability['message'])->withInput();
            }
        }

        // Validasi maksimal 2 draft PSE per user
        $draftCount = Pse::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->count();

        if ($draftCount >= 2) {
            return back()
                ->with('error', __('messages.pse.limit_draft'))
                ->withInput();
        }

        $pse = Pse::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => Auth::id(),
            'opd_id' => Auth::user()->opd_id,
            'system_name' => $validatedData['system_name'],
            'sector' => $validatedData['sector'],
            'pic_name' => $validatedData['pic_name'],
            'pic_phone' => $validatedData['pic_phone'],
            'pic_email' => $validatedData['pic_email'],
            'description' => $validatedData['description'],
            'risk_category' => $validatedData['risk_category'],
            'data_classification' => $validatedData['data_classification'],
            'private_data_info' => $validatedData['private_data_info'],
            'storage_location' => $validatedData['storage_location'],
            'status' => 'draft',
        ]);

        // Subdomains dikirim sebagai array dari hidden inputs via template x-for
        $subdomains = $validatedData['subdomains'];
        $subdomainPath = null;

        // Handle upload surat permohonan subdomain (Satu surat untuk semua subdomain)
        if ($request->hasFile('surat_subdomain')) {
            $file = $request->file('surat_subdomain');
            $uuidFileName = (string) Str::uuid() . '.pdf';
            $descriptiveName = sprintf(
                '%s_surat_permohonan_subdomain_baru_%s.pdf',
                format_filename_timestamp(),
                Str::slug($validatedData['system_name'])
            );
            $subdomainPath = $file->storeAs('documents/subdomain', $uuidFileName, 'private');
        }

        foreach ($subdomains as $index => $name) {
            $newSubdomain = $pse->subdomainRequests()->create([
                'uuid' => (string) Str::uuid(),
                'user_id' => Auth::id(),
                'subdomain_name' => $name,
                'is_primary' => ($index === 0), // Subdomain pertama jadi utama
                'request_type' => 'baru',
                'status' => 'draft',
            ]);

            // Hubungkan berkas HANYA ke subdomain pertama (untuk menghindari duplikasi file_path di tabel documents)
            if ($subdomainPath && $index === 0) {
                $newSubdomain->document()->create([
                    'file_path' => $subdomainPath,
                    'original_name' => $descriptiveName,
                ]);
            }
        }

        // Buat HostingRequest jika lokasi adalah aplikasi
        if ($validatedData['storage_location'] === 'aplikasi') {
            $hostingRequest = HostingRequest::create([
                'uuid'               => (string) Str::uuid(),
                'pse_id'             => $pse->id,
                'user_id'            => Auth::id(),
                'request_type'       => $validatedData['hosting_request_type'],
                'hosting_type'       => $validatedData['hosting_type'],
                'cpu_cores'          => $validatedData['cpu_cores'],
                'ram_capacity'       => $validatedData['ram_capacity'],
                'storage_capacity'   => $validatedData['storage_capacity'],
                'bandwidth_capacity' => $validatedData['bandwidth_capacity'],
                'notes'              => $validatedData['hosting_notes'],
                'status'             => 'draft',
            ]);

            // Handle upload surat permohonan
            if ($request->hasFile('surat_permohonan')) {
                $file = $request->file('surat_permohonan');
                $uuidFileName = (string) Str::uuid() . '.pdf';
                $descriptiveName = sprintf(
                    '%s_surat_permohonan_hosting_%s_%s.pdf',
                    format_filename_timestamp(),
                    $validatedData['hosting_request_type'],
                    Str::slug($validatedData['system_name'])
                );

                $path = $file->storeAs('documents/hosting', $uuidFileName, 'private');
                $hostingRequest->document()->create([
                    'file_path' => $path,
                    'original_name' => $descriptiveName,
                ]);
            }
        }

        return redirect()->route('pse.index')->with('success', __('Pengajuan PSE berhasil disimpan' . ($validatedData['storage_location'] === 'aplikasi' ? ' beserta draf pengajuan hosting.' : '.')));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pse $pse)
    {
        $this->authorize('view', $pse);

        $pse->load(['user', 'opd', 'subdomainRequests.document', 'hostingRequests', 'verificationHistories.user']);

        return view('pse.show', compact('pse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pse $pse)
    {
        $this->authorize('update', $pse);

        $pse->load('hostingRequests');
        $backUrl = url()->previous();

        // Siapkan metadata untuk form
        $storageLocations = Pse::getStorageLocations();
        $sectors = Pse::getSectors();
        $riskCategories = Pse::getRiskCategories();
        $dataClassifications = Pse::getDataClassifications();

        $hostingMetadata = [
            'request_types'        => HostingRequest::getRequestTypes(),
            'hosting_types'        => HostingRequest::getHostingTypes(),
            'cpu_cores'            => HostingRequest::getCpuCores(),
            'ram_capacities'       => HostingRequest::getRamCapacities(),
            'storage_capacities'   => HostingRequest::getStorageCapacities(),
            'bandwidth_capacities' => HostingRequest::getBandwidthCapacities(),
        ];

        return view('pse.edit', compact('pse', 'backUrl', 'storageLocations', 'sectors', 'riskCategories', 'dataClassifications', 'hostingMetadata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pse $pse)
    {
        $this->authorize('update', $pse);
        $this->normalizeSubdomainInputs($request);
        $this->normalizePicPhoneInput($request);

        $validatedData = $request->validate([
            'system_name' => ['required', 'string', 'max:150', 'unique:pses,system_name,' . $pse->id, 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)]+$/u'],
            'sector' => ['required', 'string', 'in:' . implode(',', array_keys(Pse::getSectors()))],
            'pic_name' => ['required', 'string', 'max:150', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)]+$/u'],
            'pic_phone' => ['required', 'string', 'max:20', 'regex:/^62[0-9]{9,15}$/'],
            'pic_email' => ['required', 'email', 'max:150'],
            'subdomains' => ['required', 'array', 'min:1'], // Standard array from chips-input
            'subdomains.*' => $this->subdomainValidationRules(),
            'description' => ['nullable', 'string', 'max:3000', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
            'risk_category' => ['required', 'string', 'in:rendah,sedang,tinggi'],
            'data_classification' => ['required', 'string', 'in:publik,internal,rahasia,sangat rahasia'],
            'private_data_info' => ['nullable', 'string', 'max:2000', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
            'storage_location' => ['required', 'string', 'in:' . implode(',', array_keys(\App\Models\Pse::getStorageLocations()))],

            // Validasi Hosting (Hanya jika storage_location == 'aplikasi')
            'hosting_request_type' => ['required_if:storage_location,aplikasi', 'nullable', 'string', 'in:' . implode(',', array_keys(HostingRequest::getRequestTypes()))],
            'hosting_type' => ['required_if:storage_location,aplikasi', 'nullable', 'string', 'in:' . implode(',', array_keys(HostingRequest::getHostingTypes()))],
            'cpu_cores' => ['required_if:storage_location,aplikasi', 'nullable', 'string', 'in:' . implode(',', HostingRequest::getCpuCores())],
            'ram_capacity' => ['required_if:storage_location,aplikasi', 'nullable', 'string', 'in:' . implode(',', HostingRequest::getRamCapacities())],
            'storage_capacity' => ['required_if:storage_location,aplikasi', 'nullable', 'string', 'in:' . implode(',', HostingRequest::getStorageCapacities())],
            'bandwidth_capacity' => ['required_if:storage_location,aplikasi', 'nullable', 'string', 'in:' . implode(',', HostingRequest::getBandwidthCapacities())],
            'hosting_notes' => ['nullable', 'string', 'max:2000'],
            'surat_permohonan' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'surat_subdomain' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'pic_phone.regex' => 'Format nomor telepon PIC harus berupa nomor telepon valid yang diawali dengan kode negara 62 (contoh: 628123456789 atau 08123456789).',
        ]);

        // Validasi ketersediaan subdomain
        foreach ($validatedData['subdomains'] as $subdomainName) {
            $availability = \App\Models\SubdomainRequest::checkAvailability($subdomainName, 'baru');
            if (!$availability['available']) {
                return back()->with('error', $availability['message'])->withInput();
            }
        }

        $oldStorageLocation = $pse->getOriginal('storage_location');
        $pse->update($validatedData);
        $newStorageLocation = $pse->storage_location;

        // Task #69: Cleanup Hosting Data if changed from 'aplikasi' to something else
        if ($oldStorageLocation === 'aplikasi' && $newStorageLocation !== 'aplikasi') {
            $draftHostings = $pse->hostingRequests()
                ->whereIn('status', ['draft', 'rejected'])
                ->get();

            foreach ($draftHostings as $hosting) {
                // Physical File Removal
                if ($hosting->document) {
                    Storage::disk('private')->delete($hosting->document->file_path);
                    $hosting->document()->delete();
                }

                // Record Cleanup
                $hosting->delete();
            }

            if ($draftHostings->isNotEmpty()) {
                session()->flash('info', __('Draf pengajuan hosting sebelumnya telah dibersihkan secara otomatis karena perubahan lokasi penyimpanan.'));
            }
        }

        // Sync Subdomains
        $newSubdomainNames = $validatedData['subdomains'];
        $currentSubdomains = $pse->subdomainRequests;

        // Sync logic: Hapus yang tidak ada di list baru, tambah yang belum ada
        // Catatan: Hanya sinkronisasi jika status masih draft/rejected agar tidak mengganggu audit
        if (in_array($pse->status, ['draft', 'rejected'])) {
            $oldDoc = $pse->subdomainRequests()->whereHas('document')->first()?->document;
            $oldFilePath = $oldDoc?->file_path;
            $oldOriginalName = $oldDoc?->original_name;

            // Handle berkas baru jika diunggah
            $newSubdomainPath = null;
            $newDescriptiveName = null;
            if ($request->hasFile('surat_subdomain')) {
                // Task 72: Cleanup file fisik lama jika ada berkas baru diunggah
                if ($oldFilePath) {
                    Storage::disk('private')->delete($oldFilePath);
                }

                $file = $request->file('surat_subdomain');
                $uuidFileName = (string) Str::uuid() . '.pdf';
                $newDescriptiveName = sprintf(
                    '%s_surat_permohonan_subdomain_baru_%s.pdf',
                    format_filename_timestamp(),
                    Str::slug($validatedData['system_name'])
                );
                $newSubdomainPath = $file->storeAs('documents/subdomain', $uuidFileName, 'private');
            }

            // Task 72: Hapus data yang tidak ada di list baru beserta document record-nya
            $normalizedNewNames = array_map(fn ($n) => SubdomainHelper::normalize($n), $newSubdomainNames);
            $orphanedSubdomains = $pse->subdomainRequests()
                ->whereNotIn('subdomain_name', $normalizedNewNames)
                ->get();

            $subdomainCleanupCount = 0;
            foreach ($orphanedSubdomains as $orphaned) {
                if ($orphaned->document) {
                    $orphaned->document()->delete();
                }
                $orphaned->delete();
                $subdomainCleanupCount++;
            }

            // Task 72: Jika semua subdomain dihapus, maka file fisiknya juga dihapus
            if (empty($normalizedNewNames) && empty($newSubdomainPath) && $oldFilePath) {
                Storage::disk('private')->delete($oldFilePath);
                $oldFilePath = null;
            }

            // Tambah yang belum ada
            foreach ($newSubdomainNames as $index => $name) {
                $normalized = SubdomainHelper::normalize($name);
                $existing = $pse->subdomainRequests()->where('subdomain_name', $normalized)->first();

                if (!$existing) {
                    $newSub = $pse->subdomainRequests()->create([
                        'uuid' => (string) Str::uuid(),
                        'user_id' => Auth::id(),
                        'subdomain_name' => $normalized,
                        'is_primary' => ($index === 0),
                        'request_type' => 'baru',
                        'status' => $pse->status,
                    ]);

                    // Gunakan berkas baru atau warisi dari subdomain lama draf ini
                    $targetPath = $newSubdomainPath;
                    $originalName = $newDescriptiveName;

                    if (!$targetPath && $pse->subdomainRequests()->whereNotNull('id')->first()?->document) {
                        $doc = $pse->subdomainRequests()->whereHas('document')->first()->document;
                        $targetPath = $doc->file_path;
                        $originalName = $doc->original_name;
                    } elseif (!$targetPath && $oldFilePath) {
                        // Fallback jika primary lama baru saja terhapus, pasang dokumen lama ke primary baru
                        $targetPath = $oldFilePath;
                        $originalName = $oldOriginalName;
                    }

                    // Hubungkan berkas HANYA ke subdomain pertama (untuk menghindari duplikasi file_path di tabel documents)
                    if ($targetPath && $index === 0) {
                        $newSub->document()->create([
                            'file_path' => $targetPath,
                            'original_name' => $originalName,
                        ]);
                    }
                } else {
                    // Update is_primary status
                    $existing->update(['is_primary' => ($index === 0)]);

                    // Jika ini menjadi primary baru dan tidak punya doc, serta ada old file, re-attach doc lama
                    if ($index === 0 && !$existing->document && !$newSubdomainPath && $oldFilePath) {
                        $existing->document()->create([
                            'file_path' => $oldFilePath,
                            'original_name' => $oldOriginalName,
                        ]);
                    }

                    // Jika ada berkas baru, update berkas HANYA pada subdomain utama (index 0)
                    if ($newSubdomainPath && $index === 0) {
                        if ($existing->document) {
                            $existing->document->update([
                                'file_path' => $newSubdomainPath,
                                'original_name' => $newDescriptiveName,
                            ]);
                        } else {
                            $existing->document()->create([
                                'file_path' => $newSubdomainPath,
                                'original_name' => $newDescriptiveName,
                            ]);
                        }
                    }
                }
            }
        }

        // Update atau Create HostingRequest jika lokasi adalah aplikasi
        if ($validatedData['storage_location'] === 'aplikasi') {
            $hostingRequest = HostingRequest::updateOrCreate(
                ['pse_id' => $pse->id],
                [
                    'user_id'            => Auth::id(),
                    'request_type'       => $validatedData['hosting_request_type'],
                    'hosting_type'       => $validatedData['hosting_type'],
                    'cpu_cores'          => $validatedData['cpu_cores'],
                    'ram_capacity'       => $validatedData['ram_capacity'],
                    'storage_capacity'   => $validatedData['storage_capacity'],
                    'bandwidth_capacity' => $validatedData['bandwidth_capacity'],
                    'notes'              => $validatedData['hosting_notes'],
                    // Status tetap draft atau mengikuti yang sudah ada jika perlu
                    'status'             => $pse->hostingRequests()->first()->status ?? 'draft',
                    'uuid'               => $pse->hostingRequests()->first()->uuid ?? (string) Str::uuid(),
                ]
            );

            // Handle upload surat permohonan jika ada berkas baru
            if ($request->hasFile('surat_permohonan')) {
                // Hapus dokumen lama jika ada
                if ($hostingRequest->document) {
                    Storage::disk('private')->delete($hostingRequest->document->file_path);
                    $hostingRequest->document->delete();
                }

                $file = $request->file('surat_permohonan');
                $uuidFileName = (string) Str::uuid() . '.pdf';
                $descriptiveName = sprintf(
                    '%s_surat_permohonan_hosting_%s_%s.pdf',
                    format_filename_timestamp(),
                    $validatedData['hosting_request_type'],
                    Str::slug($validatedData['system_name'])
                );

                $path = $file->storeAs('documents/hosting', $uuidFileName, 'private');
                $hostingRequest->document()->create([
                    'file_path' => $path,
                    'original_name' => $descriptiveName,
                ]);
            }
        }

        $successMsg = __('Pengajuan PSE berhasil diperbarui' . ($validatedData['storage_location'] === 'aplikasi' ? ' beserta rincian hosting.' : '.'));

        if (isset($draftHostings) && $draftHostings->isNotEmpty()) {
            $successMsg .= ' ' . __('Draf pengajuan hosting sebelumnya telah dibersihkan secara otomatis karena perubahan lokasi penyimpanan.');
        }
        if (isset($subdomainCleanupCount) && $subdomainCleanupCount > 0) {
            $successMsg .= ' ' . __('Beberapa data pengajuan subdomain yang kosong telah dibersihkan secara otomatis.');
        }

        return redirect()->route('pse.index')->with('success', $successMsg);
    }

    /**
     * Submit PSE for verification.
     */
    public function submit(Pse $pse)
    {
        $this->authorize('update', $pse);

        // Hanya draft dan rejected yang bisa diajukan (kembali)
        if (!in_array($pse->status, ['draft', 'rejected'])) {
            return back()->with('error', __('messages.pse.submit_error_status', ['status' => $pse->status]));
        }

        // Validasi ketersediaan seluruh subdomain sebelum diajukan (mencegah bentrok jika ada yang mengambilnya saat masih draf)
        foreach ($pse->subdomainRequests as $subdomain) {
            $availability = \App\Models\SubdomainRequest::checkAvailability($subdomain->subdomain_name, 'baru', $subdomain->id);
            if (!$availability['available']) {
                return redirect()->route('pse.edit', $pse)->with('error', $availability['message']);
            }
        }

        // Validasi kelengkapan berkas subdomain (Single Flow)
        $firstSub = $pse->subdomainRequests()->first();
        if ($firstSub && !$firstSub->document) {
            return redirect()
                ->route('pse.edit', $pse)
                ->with('error', __('messages.error.pse_upload_required_subdomain'));
        }

        // Validasi kelengkapan berkas hosting jika penyimpanan di aplikasi (Single Flow)
        if ($pse->storage_location === 'aplikasi') {
            $hostingRequest = $pse->hostingRequests()->first();
            if (!$hostingRequest || !$hostingRequest->document) {
                return redirect()
                    ->route('pse.edit', $pse)
                    ->with('error', __('messages.error.pse_upload_required_hosting'));
            }
        }

        DB::transaction(function () use ($pse) {
            // Sync OPD ID from user (crucial if draft was created without OPD)
            // Update status PSE dan sinkronisasi OPD
            $pse->update([
                'status' => 'pending_1',
                'opd_id' => Auth::user()->opd_id,
            ]);

            // Sinkronisasi status hosting (Single Flow)
            // Jika ada hosting berstatus draft atau rejected, ikut diajukan ke Verifikator 1
            $pse->hostingRequests()
                ->whereIn('status', ['draft', 'rejected'])
                ->update(['status' => 'pending_1']);

            // Sinkronisasi status subdomain (Single Flow)
            // Seluruh subdomain yang masih draft atau rejected ikut diajukan
            $pse->subdomainRequests()
                ->whereIn('status', ['draft', 'rejected'])
                ->update(['status' => 'pending_1']);
        });

        return redirect()->route('pse.index')->with('success', __('messages.pse.submit_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pse $pse)
    {
        $this->authorize('delete', $pse);

        // Store data for logging before deletion
        $pseData = [
            'id' => $pse->id,
            'uuid' => $pse->uuid,
            'system_name' => $pse->system_name,
            'status' => $pse->status,
        ];

        $pse->delete();

        // Log critical action
        Log::warning('PSE deleted', [
            'action' => 'delete',
            'resource_type' => 'pse',
            'resource_id' => $pseData['id'],
            'resource_uuid' => $pseData['uuid'],
            'pse_system_name' => $pseData['system_name'],
            'pse_status' => $pseData['status'],
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'user_role' => auth()->user()->role->role_name,
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('pse.index')->with('success', __('messages.pse.delete_success'));
    }

    private function normalizeSubdomainInputs(Request $request): void
    {
        if (!$request->has('subdomains') || !is_array($request->input('subdomains'))) {
            return;
        }

        $subdomains = collect($request->input('subdomains'))
            ->map(fn ($subdomain) => is_string($subdomain) ? SubdomainHelper::normalize($subdomain) : null)
            ->filter(fn ($subdomain) => $subdomain !== null && $subdomain !== '')
            ->values()
            ->all();

        $request->merge(['subdomains' => $subdomains]);
    }

    private function subdomainValidationRules(): array
    {
        return [
            'required',
            'string',
            'max:63',
            'distinct',
            'regex:/^[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?$/',
        ];
    }

    /**
     * Menormalisasi format nomor telepon PIC sebelum validasi dan penyimpanan.
     */
    private function normalizePicPhoneInput(Request $request): void
    {
        if ($request->has('pic_phone')) {
            $request->merge([
                'pic_phone' => normalize_phone($request->input('pic_phone'))
            ]);
        }
    }
}
