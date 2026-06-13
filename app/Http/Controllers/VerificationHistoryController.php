<?php

namespace App\Http\Controllers;

use App\Models\HostingRequest;
use App\Models\Pse;
use App\Models\SubdomainRequest;
use App\Models\VerificationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationHistoryController extends Controller
{
    /**
     * Daftar riwayat verifikasi (PSE, Subdomain, Hosting).
     * Keamanan: whitelist tab, mapping kolom sort per tab, sanitasi pencarian.
     */
    public function index(Request $request)
    {
        // Whitelist tab: hanya nilai terdaftar yang diterima, mencegah XSS dan crash logika
        $allowedTabs = ['pse', 'subdomain', 'hosting'];
        $tab = $request->query('tab', 'pse');

        if (!in_array($tab, $allowedTabs, true)) {
            $tab = 'pse';
        }
        $search = $request->query('search');

        // Logika parameter sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = normalizeSortDirection($request->get('sort_dir'), 'desc');

        $query = VerificationHistory::where('verification_histories.user_id', Auth::id());

        // Logika filter berdasarkan Tab
        if ($tab === 'pse') {
            $query->select('verification_histories.*')
                ->where('verifiable_type', Pse::class)
                ->leftJoin('pses', 'verification_histories.verifiable_id', '=', 'pses.id')
                ->with(['verifiable', 'verifiable.opd']);

            if ($search) {
                $query->where('pses.system_name', 'like', "%" . escapeLike($search) . "%");
            }

            // Mapping kolom sort: petakan ke kolom tabel yang benar, cegah QueryException
            $sortMapping = [
                'system_name' => 'pses.system_name',
                'created_at'  => 'verification_histories.created_at',
            ];
            $sortColumn = $sortMapping[$sortBy] ?? 'verification_histories.created_at';
            $query->orderBy($sortColumn, $sortDir);
        } elseif ($tab === 'subdomain') {
            $query->select('verification_histories.*')
                ->where('verifiable_type', SubdomainRequest::class)
                ->leftJoin('subdomain_requests', 'verification_histories.verifiable_id', '=', 'subdomain_requests.id')
                ->leftJoin('pses', 'subdomain_requests.pse_id', '=', 'pses.id')
                ->with(['verifiable', 'verifiable.pse']);

            if ($search) {
                $searchContent = escapeLike($search);
                $query->where(function($q) use ($searchContent) {
                    $q->where('subdomain_requests.subdomain_name', 'like', "%{$searchContent}%")
                      ->orWhere('pses.system_name', 'like', "%{$searchContent}%");
                });
            }

            // Mapping kolom: 'subdomain_name' diarahkan ke tabel subdomain_requests (bukan pses)
            $sortMapping = [
                'system_name'    => 'pses.system_name',
                'subdomain_name' => 'subdomain_requests.subdomain_name',
                'created_at'     => 'verification_histories.created_at',
            ];
            $sortColumn = $sortMapping[$sortBy] ?? 'verification_histories.created_at';
            $query->orderBy($sortColumn, $sortDir);
        } elseif ($tab === 'hosting') {
            $query->select('verification_histories.*')
                ->where('verifiable_type', HostingRequest::class)
                ->leftJoin('hosting_requests', 'verification_histories.verifiable_id', '=', 'hosting_requests.id')
                ->leftJoin('pses', 'hosting_requests.pse_id', '=', 'pses.id')
                ->with(['verifiable', 'verifiable.pse']);

            if ($search) {
                $searchContent = escapeLike($search);
                $query->where(function($q) use ($searchContent) {
                    $q->where('hosting_requests.hosting_type', 'like', "%{$searchContent}%")
                      ->orWhere('pses.system_name', 'like', "%{$searchContent}%");
                });
            }

            // Mapping kolom sort: sort_by yang tidak valid di-fallback ke created_at
            $sortMapping = [
                'system_name'  => 'pses.system_name',
                'hosting_type' => 'hosting_requests.hosting_type',
                'created_at'   => 'verification_histories.created_at',
            ];
            $sortColumn = $sortMapping[$sortBy] ?? 'verification_histories.created_at';
            $query->orderBy($sortColumn, $sortDir);
        } else {
            $histories = collect([]);
            return view('verification-history.index', compact('tab', 'histories'));
        }

        // Eksekusi query dengan pagination
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;
        $histories = $query->paginate($perPage);
        $histories->appends([
            'tab' => $tab,
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
            'per_page' => $perPageReq
        ]);

        return view('verification-history.index', compact('tab', 'histories'));
    }
}
