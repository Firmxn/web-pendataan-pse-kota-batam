<?php

namespace App\Http\Controllers;

use App\Models\HostingRequest;
use App\Models\Pse;
use App\Models\SubdomainRequest;
use App\Models\VerificationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PseVerification2Controller extends Controller
{
    /**
     * Display list PSE untuk verifikasi (verifikator_2)
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Pse::query()
            ->select('pses.*')
            ->with(['user', 'opd'])
            ->leftJoin('opds', 'pses.opd_id', '=', 'opds.id')
            ->where('pses.status', 'pending_2');

        // Sanitasi: escape wildcard (% _) agar tidak dieksploitasi untuk query abuse
        if ($request->has('search')) {
            $search = escapeLike($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('pses.system_name', 'like', "%{$search}%")
                  ->orWhere('opds.name', 'like', "%{$search}%");
            });
        }

        // Whitelist: hanya kolom terdaftar yang diizinkan untuk sorting, mencegah SQL injection via orderBy
        $allowedSortFields = ['system_name', 'sector', 'name', 'created_at'];
        $sortBy = $request->get('sort_by', 'created_at');
        // Normalisasi: hanya 'asc'/'desc' yang diterima, string liar di-fallback ke default
        $sortDir = normalizeSortDirection($request->get('sort_dir'), 'desc');

        if (in_array($sortBy, $allowedSortFields)) {
            if ($sortBy === 'name') {
                $query->orderBy('opds.name', $sortDir);
            } else {
                $query->orderBy("pses.{$sortBy}", $sortDir);
            }
        } else {
            // Fallback: sort_by tidak valid dikembalikan ke default aman
            $query->latest('pses.created_at');
        }

        // Pagination
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        $pses = $query->paginate($perPage);
        $pses->appends([
            'search' => $request->search,
            'per_page' => $request->per_page,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
        ]);

        // Menggunakan view yang sama dengan verifikator_1 (dideteksi via $isFinal)
        return view('pse-verification.index', compact('pses'));
    }

    /**
     * Show detail PSE untuk verifikasi final
     */
    public function show(Pse $pse)
    {
        // Hanya verifikator_2 yang bisa akses
        $this->authorize('view', $pse);

        // Load relasi beserta pengajuan hosting & subdomain terkait
        $pse->load(['user', 'opd', 'subdomainRequests.document', 'verificationHistories.user', 'hostingRequests.document']);

        return view('pse-verification.show', compact('pse'));
    }

    /**
     * Approve PSE (pending_2 → approved) - FINAL APPROVAL
     */
    public function approve(Request $request, Pse $pse)
    {
        // Hanya verifikator_2 yang bisa akses
        $this->authorize('verifyFinal', $pse);

        $validated = $request->validate([
            'notes' => ['nullable', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
            'registration_number' => ['required', 'string', 'max:100', 'unique:pses,registration_number', 'regex:/^[\p{L}\p{N}\s\-\.\/]+$/u'],
        ]);


        DB::transaction(function () use ($pse, $validated) {
            // Update status PSE dan nomor pendataan PSE
            $pse->update([
                'status' => 'approved',
                'registration_number' => $validated['registration_number'],
            ]);

            // Simpan riwayat verifikasi PSE
            VerificationHistory::create([
                'user_id' => Auth::id(),
                'verifiable_id' => $pse->id,
                'verifiable_type' => Pse::class,
                'status' => 'approved',
                'notes' => $validated['notes'] ?? 'Disetujui oleh Verifikator 2 (Final Approval)',
            ]);

            // Sinkronisasi status hosting (Single Flow)
            $hostings = $pse->hostingRequests()->where('status', 'pending_2')->get();
            foreach ($hostings as $hosting) {
                $hosting->update(['status' => 'approved']);
                VerificationHistory::create([
                    'user_id' => Auth::id(),
                    'verifiable_id' => $hosting->id,
                    'verifiable_type' => HostingRequest::class,
                    'status' => 'approved',
                    'notes' => $validated['notes'] ?? 'Disetujui oleh Verifikator 2 (Final Approval)',
                ]);
            }

            // Sinkronisasi status seluruh subdomain (Single Flow 1-N)
            $subdomains = $pse->subdomainRequests()->where('status', 'pending_2')->get();
            foreach ($subdomains as $subdomain) {
                $subdomain->update(['status' => 'approved']);
                VerificationHistory::create([
                    'user_id' => Auth::id(),
                    'verifiable_id' => $subdomain->id,
                    'verifiable_type' => SubdomainRequest::class,
                    'status' => 'approved',
                    'notes' => $validated['notes'] ?? 'Disetujui oleh Verifikator 2 (Final Approval)',
                ]);
            }
        });

        // Log critical action
        Log::info('PSE approved by verifikator_2 (FINAL)', [
            'action' => 'approve_final',
            'resource_type' => 'pse',
            'resource_id' => $pse->id,
            'resource_uuid' => $pse->uuid,
            'pse_system_name' => $pse->system_name,
            'registration_number' => $validated['registration_number'],
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'user_role' => 'verifikator_2',
            'notes' => $validated['notes'] ?? null,
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('pse-verification2.index')
                         ->with('success', __('messages.pse.verify2_approved', ['number' => $validated['registration_number']]));
    }

    /**
     * Reject PSE (pending_2 → rejected) - FINAL REJECTION
     */
    public function reject(Request $request, Pse $pse)
    {
        // Hanya verifikator_2 yang bisa akses
        $this->authorize('verifyFinal', $pse);

        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\.,\/\(\)\n\r:]+$/u'],
        ]);


        DB::transaction(function () use ($pse, $validated) {
            // Update status PSE
            $pse->update(['status' => 'rejected']);

            // Simpan riwayat verifikasi PSE
            VerificationHistory::create([
                'user_id' => Auth::id(),
                'verifiable_id' => $pse->id,
                'verifiable_type' => Pse::class,
                'status' => 'rejected',
                'notes' => $validated['notes'],
            ]);

            // Sinkronisasi status hosting (Single Flow)
            $hostings = $pse->hostingRequests()->where('status', 'pending_2')->get();
            foreach ($hostings as $hosting) {
                $hosting->update(['status' => 'rejected']);
                VerificationHistory::create([
                    'user_id' => Auth::id(),
                    'verifiable_id' => $hosting->id,
                    'verifiable_type' => HostingRequest::class,
                    'status' => 'rejected',
                    'notes' => $validated['notes'],
                ]);
            }

            // Sinkronisasi status seluruh subdomain (Single Flow 1-N)
            $subdomains = $pse->subdomainRequests()->where('status', 'pending_2')->get();
            foreach ($subdomains as $subdomain) {
                $subdomain->update(['status' => 'rejected']);
                VerificationHistory::create([
                    'user_id' => Auth::id(),
                    'verifiable_id' => $subdomain->id,
                    'verifiable_type' => SubdomainRequest::class,
                    'status' => 'rejected',
                    'notes' => $validated['notes'],
                ]);
            }
        });

        // Log critical action
        Log::warning('PSE rejected by verifikator_2 (FINAL)', [
            'action' => 'reject_final',
            'resource_type' => 'pse',
            'resource_id' => $pse->id,
            'resource_uuid' => $pse->uuid,
            'pse_system_name' => $pse->system_name,
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'user_role' => 'verifikator_2',
            'notes' => $validated['notes'],
            'timestamp' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('pse-verification2.index')
                         ->with('success', __('messages.pse.verify2_rejected'));
    }
}
