<?php

namespace App\Http\Controllers;

use App\Models\SubdomainRequest;
use App\Models\VerificationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubdomainVerificationController extends Controller
{
    /**
     * Daftar pengajuan subdomain tahap 1 (verifikator_1).
     * Keamanan: mapping kolom sort eksplisit, sanitasi pencarian via escapeLike().
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = SubdomainRequest::query()
            ->select('subdomain_requests.*')
            ->with(['pse', 'user'])
            ->join('pses', 'subdomain_requests.pse_id', '=', 'pses.id')
            ->join('opds', 'pses.opd_id', '=', 'opds.id')
            ->where('subdomain_requests.status', 'pending_1');

        // Logika pencarian
        if ($request->has('search')) {
            $search = escapeLike($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('subdomain_requests.subdomain_name', 'like', "%{$search}%")
                  ->orWhere('pses.system_name', 'like', "%{$search}%")
                  ->orWhere('opds.name', 'like', "%{$search}%");
            });
        }

        // Mapping kolom: petakan sort_by ke kolom tabel sesungguhnya, cegah QueryException
        $sortMapping = [
            'subdomain_name' => 'subdomain_requests.subdomain_name',
            'request_type'   => 'subdomain_requests.request_type',
            'system_name'    => 'pses.system_name',
            'name'           => 'opds.name',
            'created_at'     => 'subdomain_requests.created_at',
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $sortColumn = $sortMapping[$sortBy] ?? 'subdomain_requests.created_at';
        $sortDir = normalizeSortDirection($request->get('sort_dir'), 'desc');

        $query->orderBy($sortColumn, $sortDir);

        // Pagination
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        $subdomains = $query->paginate($perPage);
        $subdomains->appends([
            'search' => $request->search,
            'per_page' => $request->per_page,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
        ]);

        return view('subdomain-verification.index', compact('subdomains'));
    }

    public function show(SubdomainRequest $subdomain)
    {
        $this->authorize('view', $subdomain);

        $subdomain->load([
            'pse.subdomainRequests.document',
            'pse.opd',
            'user',
            'verificationHistories.user'
        ]);

        return view('subdomain-verification.show', compact('subdomain'));
    }

    public function approve(Request $request, SubdomainRequest $subdomain)
    {
        $this->authorize('verify', $subdomain);

        $validated = $request->validate([
            'notes' => ['nullable', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
        ]);


        DB::transaction(function () use ($subdomain, $validated) {
            $newStatus = 'pending_2';
            $oldStatus = $subdomain->getOriginal('status');
            $notes = $validated['notes'] ?? 'Disetujui oleh verifikator 1 dan diteruskan ke Verifikator 2';

            // 1. Update diri sendiri
            $subdomain->update(['status' => $newStatus]);
            VerificationHistory::create([
                'verifiable_type' => SubdomainRequest::class,
                'verifiable_id' => $subdomain->id,
                'user_id' => auth()->id(),
                'notes' => $notes,
                'status' => $newStatus
            ]);

            // 2. Sinkronisasi Single Flow (Bubble-Up & Lateral)
            $pse = $subdomain->pse;
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

                // Update Hosting Rekan (jika ada)
                $hostings = $pse->hostingRequests()->where('status', $oldStatus)->get();
                foreach ($hostings as $hosting) {
                    $hosting->update(['status' => $newStatus]);
                    VerificationHistory::create([
                        'verifiable_type' => \App\Models\HostingRequest::class,
                        'verifiable_id' => $hosting->id,
                        'user_id' => auth()->id(),
                        'notes' => $notes,
                        'status' => $newStatus
                    ]);
                }

                // Update Seluruh Subdomain rekan satu paket lainnya yang berstatus sama
                $siblings = $pse->subdomainRequests()->where('status', $oldStatus)->where('id', '!=', $subdomain->id)->get();
                foreach ($siblings as $sibling) {
                    $sibling->update(['status' => $newStatus]);
                    VerificationHistory::create([
                        'verifiable_type' => \App\Models\SubdomainRequest::class,
                        'verifiable_id' => $sibling->id,
                        'user_id' => auth()->id(),
                        'notes' => $notes,
                        'status' => $newStatus
                    ]);
                }
            }
        });

        // Log critical action
        Log::info('Subdomain approved by verifikator_1', [
            'action' => 'approve',
            'resource_type' => 'subdomain',
            'resource_id' => $subdomain->id,
            'resource_uuid' => $subdomain->uuid,
            'subdomain_name' => $subdomain->subdomain_name,
            'pse_system_name' => $subdomain->pse->system_name,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'user_role' => 'verifikator_1',
            'notes' => $validated['notes'] ?? null,
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('subdomain-verification.index')
                         ->with('success', __('messages.subdomain.verify_approved'));
    }

    public function reject(Request $request, SubdomainRequest $subdomain)
    {
        $this->authorize('verify', $subdomain);

        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
        ]);


        DB::transaction(function () use ($subdomain, $validated) {
            $newStatus = 'rejected';
            $oldStatus = $subdomain->getOriginal('status');
            $notes = $validated['notes'];

            // 1. Update diri sendiri
            $subdomain->update(['status' => $newStatus]);
            VerificationHistory::create([
                'verifiable_type' => SubdomainRequest::class,
                'verifiable_id' => $subdomain->id,
                'user_id' => auth()->id(),
                'notes' => $notes,
                'status' => $newStatus
            ]);

            // 2. Sinkronisasi Single Flow (Bubble-Up & Lateral)
            $pse = $subdomain->pse;
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

                // Update Hosting Rekan (jika ada)
                $hostings = $pse->hostingRequests()->where('status', $oldStatus)->get();
                foreach ($hostings as $hosting) {
                    $hosting->update(['status' => $newStatus]);
                    VerificationHistory::create([
                        'verifiable_type' => \App\Models\HostingRequest::class,
                        'verifiable_id' => $hosting->id,
                        'user_id' => auth()->id(),
                        'notes' => $notes,
                        'status' => $newStatus
                    ]);
                }

                // Update Seluruh Subdomain rekan satu paket lainnya yang berstatus sama
                $siblings = $pse->subdomainRequests()->where('status', $oldStatus)->where('id', '!=', $subdomain->id)->get();
                foreach ($siblings as $sibling) {
                    $sibling->update(['status' => $newStatus]);
                    VerificationHistory::create([
                        'verifiable_type' => \App\Models\SubdomainRequest::class,
                        'verifiable_id' => $sibling->id,
                        'user_id' => auth()->id(),
                        'notes' => $notes,
                        'status' => $newStatus
                    ]);
                }
            }
        });

        // Log critical action
        Log::warning('Subdomain rejected by verifikator_1', [
            'action' => 'reject',
            'resource_type' => 'subdomain',
            'resource_id' => $subdomain->id,
            'resource_uuid' => $subdomain->uuid,
            'subdomain_name' => $subdomain->subdomain_name,
            'pse_system_name' => $subdomain->pse->system_name,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'user_role' => 'verifikator_1',
            'notes' => $validated['notes'],
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('subdomain-verification.index')
                         ->with('success', __('messages.subdomain.verify_rejected'));

    }
}
