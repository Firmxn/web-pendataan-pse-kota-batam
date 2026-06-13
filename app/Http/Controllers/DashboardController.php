<?php

namespace App\Http\Controllers;

use App\Models\HostingRequest;
use App\Models\Pse;
use App\Models\SubdomainRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        $user = Auth::user();

        $data = [
            'total_pse' => 0,
            'total_subdomain' => 0,
            'total_hosting' => 0,
            'new_pse' => 0,
            'new_subdomain' => 0,
            'new_hosting' => 0,
        ];

        // Logic Dashboard untuk Petugas
        if ($user->role && $user->role->role_name === 'petugas') {
            $data['total_pse'] = Pse::where('user_id', $user->id)->count();
            $data['total_subdomain'] = SubdomainRequest::where('user_id', $user->id)->count();
            $data['total_hosting'] = HostingRequest::where('user_id', $user->id)->count();

            // Trends (Submitted This Month)
            $data['new_pse'] = Pse::where('user_id', $user->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
            $data['new_subdomain'] = SubdomainRequest::where('user_id', $user->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
            $data['new_hosting'] = HostingRequest::where('user_id', $user->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

            // Chart Data for Petugas
            $chartData = $this->getPetugasActivity($user->id);
            $chartData['chart_title'] = __('Aktivitas Pendataan Harian');
            $data = array_merge($data, $chartData);
        }

        // Logic Dashboard untuk Verifikator 1 (Menunggu Verifikasi Tingkat 1)
        if ($user->role && $user->role->role_name === 'verifikator_1') {
            $data['verify_pse'] = Pse::where('status', 'pending_1')->count();
            $data['verify_subdomain'] = SubdomainRequest::where('status', 'pending_1')->count();
            $data['verify_hosting'] = HostingRequest::where('status', 'pending_1')->count();

            // Trends (Approved This Month - Global)
            $data['new_pse'] = Pse::whereIn('status', ['pending_2', 'active'])->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();
            $data['new_subdomain'] = SubdomainRequest::whereIn('status', ['pending_2', 'active'])->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();
            $data['new_hosting'] = HostingRequest::whereIn('status', ['pending_2', 'active'])->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();

            // Chart Activity
            $chartData = $this->getGlobalActivity();
            $chartData['chart_title'] = __('Tren Permohonan Masuk (Global)');
            $data = array_merge($data, $chartData);
        }

        // Logic Dashboard untuk Verifikator 2 (Menunggu Verifikasi Final)
        if ($user->role && $user->role->role_name === 'verifikator_2') {
            $data['verify_pse'] = Pse::where('status', 'pending_2')->count();
            $data['verify_subdomain'] = SubdomainRequest::where('status', 'pending_2')->count();
            $data['verify_hosting'] = HostingRequest::where('status', 'pending_2')->count();

            // Trends (Approved This Month - Global)
            $data['new_pse'] = Pse::where('status', 'active')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();
            $data['new_subdomain'] = SubdomainRequest::where('status', 'active')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();
            $data['new_hosting'] = HostingRequest::where('status', 'active')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();

            // Chart Activity
            $chartData = $this->getGlobalActivity();
            $chartData['chart_title'] = __('Tren Permohonan Masuk (Global)');
            $data = array_merge($data, $chartData);
        }

        // Logic Dashboard untuk Admin & Eksekutif (Global Monitoring - Point 10)
        if ($user->role && in_array($user->role->role_name, ['admin', 'eksekutif'])) {
            $data['total_pse'] = Pse::count();
            $data['total_subdomain'] = SubdomainRequest::count();
            $data['total_hosting'] = HostingRequest::count();

            // Trends (Approved This Month)
            $data['new_pse'] = Pse::where('status', 'active')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();
            $data['new_subdomain'] = SubdomainRequest::where('status', 'active')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();
            $data['new_hosting'] = HostingRequest::where('status', 'active')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();

            // Additional User Stats for Admin/Executive
            $data['total_users'] = User::count();
            $data['new_users'] = User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

            // Chart Activity
            $chartData = $this->getGlobalActivity();
            $chartData['chart_title'] = __('Tren Permohonan Masuk (Global)');
            $data = array_merge($data, $chartData);
        }

        return view('dashboard', compact('data'));
    }

    private function getPetugasActivity($userId)
    {
        $days = 30;
        $range = collect(range($days - 1, 0))->map(function ($day) {
            return now()->subDays($day);
        });

        $categories = $range->map(fn ($date) => $date->format('Y-m-d'))->toArray();

        // Helper to map counts
        $mapCounts = function ($model) use ($userId, $range) {
            $counts = $model::where('user_id', $userId)
                ->where('created_at', '>=', now()->subDays(30))
                ->selectRaw('DATE(created_at) as date, count(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date');

            return $range->map(function ($date) use ($counts) {
                return $counts->get($date->format('Y-m-d')) ?? 0;
            })->toArray();
        };

        return [
            'chart_categories' => $categories,
            'chart_series' => [
                [
                    'name' => __('Sistem Elektronik (PSE)'),
                    'data' => $mapCounts(Pse::class)
                ],
                [
                    'name' => __('Subdomain'),
                    'data' => $mapCounts(SubdomainRequest::class)
                ],
                [
                    'name' => __('Hosting'),
                    'data' => $mapCounts(HostingRequest::class)
                ]
            ]
        ];
    }

    private function getGlobalActivity()
    {
        $days = 30;
        $range = collect(range($days - 1, 0))->map(function ($day) {
            return now()->subDays($day);
        });

        $categories = $range->map(fn ($date) => $date->format('Y-m-d'))->toArray();

        // Helper to map counts (GLOBAL - No User Filter)
        $mapCounts = function ($model) use ($range) {
            $counts = $model::where('created_at', '>=', now()->subDays(30))
                ->selectRaw('DATE(created_at) as date, count(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date');

            return $range->map(function ($date) use ($counts) {
                return $counts->get($date->format('Y-m-d')) ?? 0;
            })->toArray();
        };

        return [
            'chart_categories' => $categories,
            'chart_series' => [
                [
                    'name' => __('Permohonan PSE'),
                    'data' => $mapCounts(Pse::class)
                ],
                [
                    'name' => __('Permohonan Subdomain'),
                    'data' => $mapCounts(SubdomainRequest::class)
                ],
                [
                    'name' => __('Permohonan Hosting'),
                    'data' => $mapCounts(HostingRequest::class)
                ]
            ]
        ];
    }
}
