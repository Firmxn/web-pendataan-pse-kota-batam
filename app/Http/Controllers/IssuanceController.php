<?php

namespace App\Http\Controllers;

use App\Models\HostingRequest;
use App\Models\Pse;
use App\Models\SubdomainRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class IssuanceController extends Controller
{
    /**
     * Daftar penerbitan dan rekapitulasi (PSE, Subdomain, Hosting).
     * Keamanan: whitelist tab, mapping kolom sort per tab, sanitasi pencarian.
     */
    public function index(Request $request)
    {
        // Whitelist tab: hanya nilai terdaftar yang diterima, mencegah XSS dan crash logika
        $allowedTabs = ['pse', 'subdomain', 'hosting', 'rekap'];
        $tab = $request->query('tab', 'pse');

        if (!in_array($tab, $allowedTabs, true)) {
            $tab = 'pse';
        }
        $perPageReq = request('per_page', '10');
        $perPage = in_array($perPageReq, ['10', '25', '50', '100', 'all']) ? ($perPageReq === 'all' ? 999999 : (int) $perPageReq) : 10;

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = normalizeSortDirection($request->get('sort_dir'), 'desc');

        $search = $request->search;
        if ($tab === 'pse') {
            $query = Pse::query()
                ->select('pses.*')
                ->join('opds', 'pses.opd_id', '=', 'opds.id')
                ->where('pses.status', 'approved');

            if ($search) {
                $searchContent = escapeLike($search);
                $query->where(function ($q) use ($searchContent) {
                    $q->where('pses.system_name', 'like', "%{$searchContent}%")
                      ->orWhere('opds.name', 'like', "%{$searchContent}%")
                      ->orWhere('pses.registration_number', 'like', "%{$searchContent}%");
                });
            }

            // Mapping kolom: petakan sort_by ke kolom tabel yang benar, cegah QueryException
            $sortMapping = [
                'system_name'         => 'pses.system_name',
                'name'                => 'opds.name',
                'registration_number' => 'pses.registration_number',
                'created_at'          => 'pses.created_at',
            ];
            $sortColumn = $sortMapping[$sortBy] ?? 'pses.created_at';
            $query->orderBy($sortColumn, $sortDir);
        } elseif ($tab === 'subdomain') {
            $query = SubdomainRequest::query()
                ->select('subdomain_requests.*')
                ->join('pses', 'subdomain_requests.pse_id', '=', 'pses.id')
                ->join('opds', 'pses.opd_id', '=', 'opds.id')
                ->where('subdomain_requests.status', 'approved');

            if ($search) {
                $searchContent = escapeLike($search);
                $query->where(function ($q) use ($searchContent) {
                    $q->where('pses.system_name', 'like', "%{$searchContent}%")
                      ->orWhere('opds.name', 'like', "%{$searchContent}%")
                      ->orWhere('subdomain_requests.subdomain_name', 'like', "%{$searchContent}%");
                });
            }

            // Mapping kolom: 'subdomain_name' diarahkan ke tabel subdomain_requests (bukan pses)
            $sortMapping = [
                'system_name'    => 'pses.system_name',
                'name'           => 'opds.name',
                'subdomain_name' => 'subdomain_requests.subdomain_name',
                'created_at'     => 'subdomain_requests.created_at',
            ];
            $sortColumn = $sortMapping[$sortBy] ?? 'subdomain_requests.created_at';
            $query->orderBy($sortColumn, $sortDir);
        } elseif ($tab === 'hosting') {
            $query = HostingRequest::query()
                ->select('hosting_requests.*')
                ->join('pses', 'hosting_requests.pse_id', '=', 'pses.id')
                ->join('opds', 'pses.opd_id', '=', 'opds.id')
                ->where('hosting_requests.status', 'approved');

            if ($search) {
                $searchContent = escapeLike($search);
                $query->where(function ($q) use ($searchContent) {
                    $q->where('pses.system_name', 'like', "%{$searchContent}%")
                      ->orWhere('opds.name', 'like', "%{$searchContent}%")
                      ->orWhere('hosting_requests.hosting_type', 'like', "%{$searchContent}%");
                });
            }

            // Mapping kolom: sort_by yang tidak valid di-fallback ke created_at
            $sortMapping = [
                'system_name'  => 'pses.system_name',
                'name'         => 'opds.name',
                'hosting_type' => 'hosting_requests.hosting_type',
                'created_at'   => 'hosting_requests.created_at',
            ];
            $sortColumn = $sortMapping[$sortBy] ?? 'hosting_requests.created_at';
            $query->orderBy($sortColumn, $sortDir);
        } elseif ($tab === 'rekap') {
            $month = $request->get('month', date('n'));
            $year = $request->get('year', date('Y'));
            $category = $request->get('category', 'all');

            $pseCount = Pse::where('status', 'approved')
                ->whereHas('verificationHistories', function ($q) use ($month, $year) {
                    $q->where('status', 'approved')
                      ->whereMonth('created_at', $month)
                      ->whereYear('created_at', $year);
                })
                ->count();

            $subdomainCount = SubdomainRequest::where('status', 'approved')
                ->whereHas('verificationHistories', function ($q) use ($month, $year) {
                    $q->where('status', 'approved')
                      ->whereMonth('created_at', $month)
                      ->whereYear('created_at', $year);
                })
                ->count();

            $hostingCount = HostingRequest::where('status', 'approved')
                ->whereHas('verificationHistories', function ($q) use ($month, $year) {
                    $q->where('status', 'approved')
                      ->whereMonth('created_at', $month)
                      ->whereYear('created_at', $year);
                })
                ->count();

            $recapData = [
                'pse' => $pseCount,
                'subdomain' => $subdomainCount,
                'hosting' => $hostingCount,
                'total' => $pseCount + $subdomainCount + $hostingCount,
                'month' => $month,
                'year' => $year,
                'category' => $category
            ];

            return view('issuance.index', compact('tab', 'recapData'));
        }

        $query = $query->paginate($perPage);

        $query->appends([
            'tab' => $tab,
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
            'per_page' => $perPageReq
        ]);

        return view('issuance.index', compact('tab', 'query'));
    }

    public function printRecap(Request $request)
    {
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));
        $category = $request->get('category', 'all');

        $monthName = match ((int)$month) {
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
            default => '',
        };

        $period = "$monthName $year";
        $categoryName = match($category) {
            'pse' => 'PSE',
            'subdomain' => 'Subdomain',
            'hosting' => 'Hosting',
            default => 'Semua',
        };

        $title = "Rekapitulasi $categoryName - $period";
        $data = [
            'title' => $title,
            'period' => $period,
            'categoryName' => $categoryName,
        ];

        if ($category === 'all' || $category === 'pse') {
            $data['pseData'] = Pse::with('opd')
                ->where('status', 'approved')
                ->whereHas('verificationHistories', function ($q) use ($month, $year) {
                    $q->where('status', 'approved')
                      ->whereMonth('created_at', $month)
                      ->whereYear('created_at', $year);
                })
                ->get();
        }

        if ($category === 'all' || $category === 'subdomain') {
            $data['subdomainData'] = SubdomainRequest::with(['pse', 'pse.opd'])
                ->where('status', 'approved')
                ->whereHas('verificationHistories', function ($q) use ($month, $year) {
                    $q->where('status', 'approved')
                      ->whereMonth('created_at', $month)
                      ->whereYear('created_at', $year);
                })
                ->get();
        }

        if ($category === 'all' || $category === 'hosting') {
            $data['hostingData'] = HostingRequest::with(['pse', 'pse.opd'])
                ->where('status', 'approved')
                ->whereHas('verificationHistories', function ($q) use ($month, $year) {
                    $q->where('status', 'approved')
                      ->whereMonth('created_at', $month)
                      ->whereYear('created_at', $year);
                })
                ->get();
        }

        $pdf = Pdf::loadView('reports.recap', $data);
        $pdf->setPaper('a4', 'portrait');

        Log::info('Laporan rekapitulasi dicetak', [
            'action' => 'print_recap',
            'category' => $category,
            'period' => $period,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
        ]);

        return $pdf->stream("rekap-$category-$month-$year.pdf");
    }

    public function printPse(Pse $pse)
    {
        $pse->load(['opd', 'user', 'subdomainRequests', 'verificationHistories']);
        $pdf = Pdf::loadView('reports.pse_registration', compact('pse'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function printSubdomain(SubdomainRequest $subdomain)
    {
        $pdf = Pdf::loadView('reports.subdomain_approval', compact('subdomain'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function printHosting(HostingRequest $hosting)
    {
        $pdf = Pdf::loadView('reports.hosting_approval', compact('hosting'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function updatePse(Request $request, Pse $pse)
    {
        //cek apakah user punya akses (policy)
        $this->authorize('updateRegistrationNumber', $pse);

        try {
            //validasi data nomor pendataan PSE
            $validated = $request->validate([
                'registration_number' => ['required', 'string', 'max:100', 'unique:pses,registration_number,' . $pse->id, 'regex:/^[\p{L}\p{N}\s\-\.\/]+$/u'],
            ]);

            //update data kolom nomor pendataan PSE
            $oldRegistrationNumber = $pse->registration_number;
            $pse->update([
                'registration_number' => $validated['registration_number']
            ]);

            // Log critical action
            Log::info('PSE registration number updated', [
                'action' => 'update_registration',
                'resource_type' => 'pse',
                'resource_id' => $pse->id,
                'resource_uuid' => $pse->uuid,
                'pse_system_name' => $pse->system_name,
                'old_registration_number' => $oldRegistrationNumber,
                'new_registration_number' => $validated['registration_number'],
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email,
                'user_role' => 'verifikator_2',
                'timestamp' => now()->toIso8601String(),
                'ip_address' => request()->ip(),
            ]);

            //redirect ke halaman issuance dan tab pse dengan pesan sukses
            return redirect()->route('issuance.index', ['tab' => 'pse'])
                ->with('success', __('messages.issuance.updated'));
        } catch (ValidationException $e) {
            // Simpan UUID PSE yang error untuk auto-open modal
            return redirect()->route('issuance.index', ['tab' => 'pse'])
                ->withErrors($e->validator, 'issuance')
                ->withInput()
                ->with('editing_pse_uuid', $pse->uuid);
        }
    }
}
