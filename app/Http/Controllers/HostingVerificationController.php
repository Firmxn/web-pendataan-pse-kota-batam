<?php

namespace App\Http\Controllers;

use App\Models\HostingRequest;
use App\Models\VerificationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HostingVerificationController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = HostingRequest::query()
            ->select('hosting_requests.*')
            ->with(['pse', 'user'])
            ->join('pses', 'hosting_requests.pse_id', '=', 'pses.id')
            ->join('opds', 'pses.opd_id', '=', 'opds.id')
            ->where('hosting_requests.status', 'pending_1');

        // Sanitasi: escape wildcard (% _) agar tidak dieksploitasi untuk query abuse
        if ($request->has('search')) {
            $search = escapeLike($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('pses.system_name', 'like', "%{$search}%")
                  ->orWhere('opds.name', 'like', "%{$search}%");
            });
        }

        // Whitelist: hanya kolom terdaftar yang diizinkan untuk sorting, mencegah SQL injection via orderBy
        $allowedSortFields = ['hosting_type', 'request_type', 'system_name', 'name', 'created_at'];
        $sortBy = $request->get('sort_by', 'created_at');
        // Normalisasi: hanya 'asc'/'desc' yang diterima, string liar di-fallback ke default
        $sortDir = normalizeSortDirection($request->get('sort_dir'), 'desc');

        if (in_array($sortBy, $allowedSortFields)) {
            if ($sortBy === 'system_name') {
                $query->orderBy('pses.system_name', $sortDir);
            } elseif ($sortBy === 'name') {
                $query->orderBy('opds.name', $sortDir);
            } else {
                $query->orderBy("hosting_requests.{$sortBy}", $sortDir);
            }
        } else {
            // Fallback: sort_by tidak valid dikembalikan ke default aman
            $query->latest('hosting_requests.created_at');
        }

        // Pagination
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        $hostings = $query->paginate($perPage);
        $hostings->appends([
            'search' => $request->search,
            'per_page' => $request->per_page,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
        ]);

        return view('hosting-verification.index', compact('hostings'));
    }

    public function show(HostingRequest $hosting)
    {
        $this->authorize('view', $hosting);

        $hosting->load([
            'pse.subdomainRequests.document',
            'pse.opd',
            'user',
            'verificationHistories.user'
        ]);

        return view('hosting-verification.show', compact('hosting'));
    }

    public function approve(Request $request, HostingRequest $hosting)
    {
        $this->authorize('verify', $hosting);

        $validated = $request->validate([
            'notes' => ['nullable', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
        ]);


        DB::transaction(function () use ($hosting, $validated) {
            $newStatus = 'pending_2';
            $oldStatus = $hosting->getOriginal('status');
            $notes = $validated['notes'] ?? 'Disetujui oleh verifikator 1 dan diteruskan ke Verifikator 2';

            // 1. Update diri sendiri
            $hosting->update(['status' => $newStatus]);
            VerificationHistory::create([
                'verifiable_type' => HostingRequest::class,
                'verifiable_id' => $hosting->id,
                'user_id' => auth()->id(),
                'notes' => $notes,
                'status' => $newStatus
            ]);

            // 2. Sinkronisasi Single Flow (Bubble-Up & Lateral)
            $pse = $hosting->pse;
            if ($pse->storage_location === 'aplikasi' && $pse->status === $oldStatus) {
                // Update Induk PSE
                $pse->update(['status' => $newStatus]);
                VerificationHistory::create([
                    'verifiable_type' => \App\Models\Pse::class,
                    'verifiable_id' => $pse->id,
                    'user_id' => auth()->id(),
                    'notes' => $notes,
                    'status' => $newStatus
                ]);

                // Update Seluruh Subdomain rekan satu paket yang berstatus sama
                $subdomains = $pse->subdomainRequests()->where('status', $oldStatus)->get();
                foreach ($subdomains as $subdomain) {
                    $subdomain->update(['status' => $newStatus]);
                    VerificationHistory::create([
                        'verifiable_type' => \App\Models\SubdomainRequest::class,
                        'verifiable_id' => $subdomain->id,
                        'user_id' => auth()->id(),
                        'notes' => $notes,
                        'status' => $newStatus
                    ]);
                }
            }
        });

        // Log critical action
        Log::info('Hosting approved by verifikator_1', [
            'action' => 'approve',
            'resource_type' => 'hosting',
            'resource_id' => $hosting->id,
            'resource_uuid' => $hosting->uuid,
            'pse_system_name' => $hosting->pse->system_name,
            'request_type' => $hosting->request_type,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'user_role' => 'verifikator_1',
            'notes' => $validated['notes'] ?? null,
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('hosting-verification.index')
                         ->with('success', __('messages.hosting.verify_approved'));
    }

    public function reject(Request $request, HostingRequest $hosting)
    {
        $this->authorize('verify', $hosting);

        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
        ]);


        DB::transaction(function () use ($hosting, $validated) {
            $newStatus = 'rejected';
            $oldStatus = $hosting->getOriginal('status');
            $notes = $validated['notes'];

            // 1. Update diri sendiri
            $hosting->update(['status' => $newStatus]);
            VerificationHistory::create([
                'verifiable_type' => HostingRequest::class,
                'verifiable_id' => $hosting->id,
                'user_id' => auth()->id(),
                'notes' => $notes,
                'status' => $newStatus
            ]);

            // 2. Sinkronisasi Single Flow (Bubble-Up & Lateral)
            $pse = $hosting->pse;
            if ($pse->storage_location === 'aplikasi' && $pse->status === $oldStatus) {
                // Update Induk PSE
                $pse->update(['status' => $newStatus]);
                VerificationHistory::create([
                    'verifiable_type' => \App\Models\Pse::class,
                    'verifiable_id' => $pse->id,
                    'user_id' => auth()->id(),
                    'notes' => $notes,
                    'status' => $newStatus
                ]);

                // Update Seluruh Subdomain rekan satu paket yang berstatus sama
                $subdomains = $pse->subdomainRequests()->where('status', $oldStatus)->get();
                foreach ($subdomains as $subdomain) {
                    $subdomain->update(['status' => $newStatus]);
                    VerificationHistory::create([
                        'verifiable_type' => \App\Models\SubdomainRequest::class,
                        'verifiable_id' => $subdomain->id,
                        'user_id' => auth()->id(),
                        'notes' => $notes,
                        'status' => $newStatus
                    ]);
                }
            }
        });

        // Log critical action
        Log::warning('Hosting rejected by verifikator_1', [
            'action' => 'reject',
            'resource_type' => 'hosting',
            'resource_id' => $hosting->id,
            'resource_uuid' => $hosting->uuid,
            'pse_system_name' => $hosting->pse->system_name,
            'request_type' => $hosting->request_type,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'user_role' => 'verifikator_1',
            'notes' => $validated['notes'],
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('hosting-verification.index')
                         ->with('success', __('messages.hosting.verify_rejected'));

    }
}
