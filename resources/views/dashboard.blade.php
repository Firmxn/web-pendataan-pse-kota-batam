@section('title', __('Dashboard'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />
            @php
                $roleName = auth()->user()->role->role_name ?? 'User';
                $showTotalCards = in_array($roleName, ['petugas', 'admin', 'eksekutif']);
                $showVerifyCards = in_array($roleName, ['verifikator_1', 'verifikator_2']);
                // Admin & Eksekutif bersifat monitoring, tidak memiliki akses ke halaman data operasional
                $isMonitorOnly = in_array($roleName, ['admin', 'eksekutif']);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 {{ in_array($roleName, ['admin', 'eksekutif']) ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }} gap-6 mb-6">

                @if ($showTotalCards)
                    {{-- Card PSE (Total) --}}
                    <x-ui.stat-card :title="__('Total PSE')" :value="$data['total_pse'] ?? 0" :isGradient="true" color="primary"
                        :trend="$data['new_pse'] ?? 0" :trendLabel="$roleName === 'petugas' ? __('Disubmit bulan ini') : __('Disetujui bulan ini')" :url="$isMonitorOnly ? null : route('pse.index')" />

                    {{-- Card Subdomain (Total) --}}
                    <x-ui.stat-card :title="__('Total Subdomain')" :value="$data['total_subdomain'] ?? 0"
                        :trend="$data['new_subdomain'] ?? 0" :trendLabel="$roleName === 'petugas' ? __('Disubmit bulan ini') : __('Disetujui bulan ini')" :url="$isMonitorOnly ? null : route('subdomain.index')" />

                    {{-- Card Hosting (Total) --}}
                    <x-ui.stat-card :title="__('Total Hosting')" :value="$data['total_hosting'] ?? 0"
                        :trend="$data['new_hosting'] ?? 0" :trendLabel="$roleName === 'petugas' ? __('Disubmit bulan ini') : __('Disetujui bulan ini')"
                        :url="$isMonitorOnly ? null : route('hosting.index')" />

                    @if (in_array($roleName, ['admin', 'eksekutif']))
                        {{-- Card User (Total) --}}
                        <x-ui.stat-card :title="__('Total Pengguna')" :value="$data['total_users'] ?? 0" :trend="$data['new_users'] ?? 0"
                            :trendLabel="__('Terdaftar bulan ini')" :url="$roleName === 'admin' ? route('user.index') : null" />
                    @endif
                @elseif($showVerifyCards)
                    {{-- Card Verifikasi PSE --}}
                    <x-ui.stat-card :title="__('Verifikasi PSE')" :value="$data['verify_pse'] ?? 0" :isGradient="true"
                        color="primary" :trend="$data['new_pse'] ?? 0" :trendLabel="__('Disetujui bulan ini')" 
                        :url="$roleName === 'verifikator_1' ? route('pse-verification.index') : route('pse-verification2.index')" />

                    {{-- Card Verifikasi Subdomain --}}
                    <x-ui.stat-card :title="__('Verifikasi Subdomain')" :value="$data['verify_subdomain'] ?? 0"
                        :trend="$data['new_subdomain'] ?? 0" :trendLabel="__('Disetujui bulan ini')" 
                        :url="$roleName === 'verifikator_1' ? route('subdomain-verification.index') : route('subdomain-verification2.index')" />

                    {{-- Card Verifikasi Hosting --}}
                    <x-ui.stat-card :title="__('Verifikasi Hosting')" :value="$data['verify_hosting'] ?? 0"
                        :trend="$data['new_hosting'] ?? 0" :trendLabel="__('Disetujui bulan ini')"
                        :url="$roleName === 'verifikator_1' ? route('hosting-verification.index') : route('hosting-verification2.index')" />
                @endif
            </div>

            @if (isset($data['chart_series']))
                <div class="mb-6">
                    <x-ui.chart :title="$data['chart_title'] ?? 'Aktivitas Pendataan Harian'" :categories="$data['chart_categories']" :series="$data['chart_series']" />
                </div>
            @endif

            <div
                class="mt-8 flex items-center justify-between rounded-4xl border border-base-100 bg-base-100 px-8 py-4 backdrop-blur-sm shadow-sm transition-[transform,box-shadow] duration-500 hover:scale-[1.01] hover:shadow-2xl">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="stroke-base-content/90 h-5 w-5 shrink-0 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">{{ __('Selamat Datang di Dashboard Pendataan PSE!') }}</span>
                </div>
                <span class="text-sm font-medium text-accent">
                    {{ __('Login sebagai :role', [
                        'role' => __(Str::headline($roleName)),
                    ]) }}
                </span>
            </div>
        </div>
    </div>
</x-app-layout>
