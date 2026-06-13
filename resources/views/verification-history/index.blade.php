@section('title', __('Riwayat Verifikasi'))

@php
    $tabName = match ($tab) {
        'subdomain' => __('Subdomain'),
        'hosting' => __('Hosting'),
        default => __('PSE'),
    };
@endphp

@section('section', $tabName)

<x-app-layout>
    <x-slot name="header">
        <x-ui.heading level="2">{{ __('Riwayat Verifikasi') . ' ' . $tabName }}</x-ui.heading>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />
            {{--
            Navigasi Tab (Server-side):
            Menggunakan parameter query '?tab=...' untuk menentukan konten yang aktif.
            Setiap klik tab akan me-reload halaman.
            --}}
            <div role="tablist" class="tabs gap-2 relative z-10 px-6">
                {{-- Tab PSE --}}
                <a role="tab" href="{{ route('verification.history', ['tab' => 'pse']) }}"
                    class="tab h-10 px-6 rounded-t-lg {{ $tab == 'pse' ? 'tab-active bg-base-100 shadow-sm font-semibold text-primary' : 'text-base-content/50 hover:bg-gray-50 dark:hover:bg-base-300 hover:text-base-content' }}">
                    {{ __('PSE') }}
                </a>

                {{-- Tab Subdomain --}}
                <a role="tab" href="{{ route('verification.history', ['tab' => 'subdomain']) }}"
                    class="tab h-10 px-6 rounded-t-lg {{ $tab == 'subdomain' ? 'tab-active bg-base-100 shadow-sm font-semibold text-primary' : 'text-base-content/50 hover:bg-gray-50 dark:hover:bg-base-300 hover:text-base-content' }}">
                    {{ __('Subdomain') }}
                </a>

                {{-- Tab Hosting --}}
                <a role="tab" href="{{ route('verification.history', ['tab' => 'hosting']) }}"
                    class="tab h-10 px-6 rounded-t-lg {{ $tab == 'hosting' ? 'tab-active bg-base-100 shadow-sm font-semibold text-primary' : 'text-base-content/50 hover:bg-gray-50 dark:hover:bg-base-300 hover:text-base-content' }}">
                    {{ __('Hosting') }}
                </a>
            </div>

            {{-- Area Konten Utama (Card Style) --}}
            <x-ui.card>
                {{-- Toolbar: Pencarian --}}
                @php
                    $placeholder = match ($tab) {
                        'pse' => __('Cari sistem/PSE...'),
                        'subdomain' => __('Cari subdomain/sistem...'),
                        'hosting' => __('Cari hosting/sistem...'),
                        default => __('Cari...'),
                    };
                @endphp

                <div class="flex flex-col lg:flex-row justify-end items-stretch lg:items-center gap-4 mb-4">
                    <x-form.search-input action="{{ route('verification.history') }}" value="{{ request('search') }}"
                        placeholder="{{ $placeholder }}">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                    </x-form.search-input>
                </div>

                @if ($histories->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <x-ui.table-sort field="created_at" :label="__('Tanggal Verifikasi')" />
                                {{-- Kolom Dinamis berdasarkan Tab Aktif --}}
                                @if ($tab == 'pse')
                                    <x-ui.table-sort field="system_name" :label="__('Nama Sistem')" />
                                    <th>{{ __('OPD') }}</th>
                                @elseif($tab == 'subdomain')
                                    <x-ui.table-sort field="system_name" :label="__('Nama Sistem (PSE)')" />
                                    <x-ui.table-sort field="subdomain_name" :label="__('Subdomain')" />
                                @elseif($tab == 'hosting')
                                    <x-ui.table-sort field="system_name" :label="__('Nama Sistem (PSE)')" />
                                    <x-ui.table-sort field="hosting_type" :label="__('Tipe Hosting')" />
                                @endif
                                <th>{{ __('Status Keputusan') }}</th>
                                <th>{{ __('Catatan Saya') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($histories as $history)
                                <tr class="hover:bg-base-200">
                                    <td>{{ $histories->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            {{ format_date_indo($history->created_at) }}
                                            <span
                                                class="text-xs text-base-content/50">{{ format_time($history->created_at) }}
                                                WIB
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Tampilkan Data Spesifik per Tab --}}
                                    @if ($tab == 'pse')
                                        <td>
                                            <div class="tooltip"
                                                data-tip="{{ $history->verifiable->system_name ?? '-' }}">
                                                {{-- <span class="badge badge-ghost badge-sm min-w-24 px-4 cursor-help"> --}}
                                                {{ Str::limit($history->verifiable->system_name ?? '-', 25) }}
                                                {{-- </span> --}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="tooltip"
                                                data-tip="{{ $history->verifiable->opd->name ?? '-' }}">
                                                <span
                                                    class="cursor-help">{{ Str::limit($history->verifiable->opd->name ?? '-', 25) }}</span>
                                            </div>
                                        </td>
                                    @elseif($tab == 'subdomain')
                                        <td>
                                            <div class="tooltip"
                                                data-tip="{{ $history->verifiable->pse->system_name ?? '-' }}">
                                                <span
                                                    class="cursor-help">{{ Str::limit($history->verifiable->pse->system_name ?? '-', 25) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="tooltip"
                                                data-tip="{{ $history->verifiable->subdomain_name ?? '-' }}">
                                                <span class="badge badge-ghost badge-sm min-w-24 px-4 cursor-help">
                                                    {{ Str::limit($history->verifiable->subdomain_name ?? '-', 25) }}
                                                </span>
                                            </div>
                                        </td>
                                    @elseif($tab == 'hosting')
                                        <td>
                                            <div class="tooltip"
                                                data-tip="{{ $history->verifiable->pse->system_name ?? '-' }}">
                                                <span
                                                    class="cursor-help">{{ Str::limit($history->verifiable->pse->system_name ?? '-', 25) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-ghost badge-sm min-w-24 px-4">
                                                {{ __(ucfirst($history->verifiable->hosting_type ?? '-')) }}
                                            </span>
                                        </td>
                                    @endif

                                    <td>
                                        <x-display.status-badge :status="$history->status" />
                                    </td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $history->notes }}">
                                            <span class="text-sm text-base-content cursor-help">
                                                {{ Str::limit($history->notes, 30) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        {{-- Link Detail: Tentukan route berdasarkan role user dan tipe verifikasi --}}
                                        @php
                                            $roleName = Auth::user()->role->role_name ?? '';

                                            $routePrefix = match ($tab) {
                                                'pse' => $roleName === 'verifikator_1'
                                                    ? 'pse-verification'
                                                    : 'pse-verification2',
                                                'subdomain' => $roleName === 'verifikator_1'
                                                    ? 'subdomain-verification'
                                                    : 'subdomain-verification2',
                                                'hosting' => $roleName === 'verifikator_1'
                                                    ? 'hosting-verification'
                                                    : 'hosting-verification2',
                                                default => '#',
                                            };
                                        @endphp

                                        {{-- Cek jika data pengajuan asli belum dihapus secara fisik --}}
                                        @if ($history->verifiable)
                                            <x-button.info href="{{ route($routePrefix . '.show', $history->verifiable) }}"
                                                size="sm" icon="eye">
                                                {{ __('Detail') }}
                                            </x-button.info>
                                        @else
                                            <span class="text-xs text-base-content/50 italic">{{ __('Data dihapus') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    {{-- Pagination (Append query params agar tab dan search tidak hilang) --}}
                    <div class="mt-6">
                        {{ $histories->appends(['tab' => $tab, 'search' => request('search')])->links() }}
                    </div>
                @else
                    {{-- Empty State: Dibedakan antara hasil pencarian nihil vs data kosong --}}
                    <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                        @if (request('search'))
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <p class="text-lg font-medium">{{ __('Pencarian tidak ditemukan.') }}</p>
                            <p class="text-sm">{{ __('Tidak ada hasil untuk kata kunci') }}
                                "<strong>{{ request('search') }}</strong>"
                            </p>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-lg font-medium">
                                {{ __('Belum ada riwayat verifikasi ') . $tabName . '.' }}</p>
                            <p class="text-sm">{{ __('Anda belum melakukan verifikasi pada kategori ini.') }}</p>
                        @endif
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
