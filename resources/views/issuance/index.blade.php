@section('title', __('Penerbitan'))

@php
    $tabName = match ($tab) {
        'subdomain' => __('Subdomain'),
        'hosting' => __('Hosting'),
        'rekap' => __('Rekap Laporan'),
        default => __('PSE'),
    };
@endphp

@section('section', $tabName)

<x-app-layout>
    <x-slot name="header">
        <x-ui.heading level="2">{{ __('Penerbitan') . ' ' . $tabName }}</x-ui.heading>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            {{-- Navigasi Tab --}}
            <div role="tablist" class="tabs gap-2 relative z-10 px-6">
                <a role="tab" href="{{ route('issuance.index', ['tab' => 'pse']) }}"
                    class="tab h-10 px-6 rounded-t-lg {{ $tab == 'pse' ? 'tab-active bg-base-100 shadow-sm font-semibold text-primary' : 'text-base-content/50 hover:bg-gray-50 dark:hover:bg-base-300 hover:text-base-content' }}">
                    {{ __('PSE') }}
                </a>
                <a role="tab" href="{{ route('issuance.index', ['tab' => 'subdomain']) }}"
                    class="tab h-10 px-6 rounded-t-lg {{ $tab == 'subdomain' ? 'tab-active bg-base-100 shadow-sm font-semibold text-primary' : 'text-base-content/50 hover:bg-gray-50 dark:hover:bg-base-300 hover:text-base-content' }}">
                    {{ __('Subdomain') }}
                </a>
                <a role="tab" href="{{ route('issuance.index', ['tab' => 'hosting']) }}"
                    class="tab h-10 px-6 rounded-t-lg {{ $tab == 'hosting' ? 'tab-active bg-base-100 shadow-sm font-semibold text-primary' : 'text-base-content/50 hover:bg-gray-50 dark:hover:bg-base-300 hover:text-base-content' }}">
                    {{ __('Hosting') }}
                </a>
                <a role="tab" href="{{ route('issuance.index', ['tab' => 'rekap']) }}"
                    class="tab h-10 px-6 rounded-t-lg {{ $tab == 'rekap' ? 'tab-active bg-base-100 shadow-sm font-semibold text-primary' : 'text-base-content/50 hover:bg-gray-50 dark:hover:bg-base-300 hover:text-base-content' }}">
                    {{ __('Rekap Laporan') }}
                </a>
            </div>

            {{-- Area Konten Utama --}}
            <x-ui.card>
                @php
                    $placeholder = match ($tab) {
                        'pse' => __('Cari sistem/PSE...'),
                        'subdomain' => __('Cari subdomain/sistem...'),
                        'hosting' => __('Cari hosting/sistem...'),
                        default => __('Cari...'),
                    };
                @endphp

                @if ($tab !== 'rekap')
                    <div class="flex flex-col lg:flex-row justify-end items-stretch lg:items-center gap-4 mb-4">
                        <x-form.search-input action="{{ route('issuance.index') }}" value="{{ request('search') }}"
                            placeholder="{{ $placeholder }}">
                            <input type="hidden" name="tab" value="{{ $tab }}">
                        </x-form.search-input>
                    </div>
                @else
                    <div class="mb-6">
                        <x-ui.card class="shadow-none! border border-base-200">
                            <form action="{{ route('issuance.index') }}" method="GET"
                                class="flex flex-wrap justify-between items-end gap-4 p-0">
                                <input type="hidden" name="tab" value="rekap">

                                <div class="flex gap-2">
                                    <div class="w-full md:w-48">
                                        <x-form.fieldset label="{{ __('Kategori') }}">
                                            <x-form.select name="category">
                                                <option value="all"
                                                    {{ ($recapData['category'] ?? '') == 'all' ? 'selected' : '' }}>
                                                    {{ __('Semua Kategori') }}
                                                </option>
                                                <option value="pse"
                                                    {{ ($recapData['category'] ?? '') == 'pse' ? 'selected' : '' }}>
                                                    {{ __('Hanya PSE') }}
                                                </option>
                                                <option value="subdomain"
                                                    {{ ($recapData['category'] ?? '') == 'subdomain' ? 'selected' : '' }}>
                                                    {{ __('Hanya Subdomain') }}
                                                </option>
                                                <option value="hosting"
                                                    {{ ($recapData['category'] ?? '') == 'hosting' ? 'selected' : '' }}>
                                                    {{ __('Hanya Hosting') }}
                                                </option>
                                            </x-form.select>
                                        </x-form.fieldset>
                                    </div>

                                    <div class="w-full md:w-40">
                                        <x-form.fieldset label="{{ __('Bulan') }}">
                                            <x-form.select name="month">
                                                @foreach (range(1, 12) as $m)
                                                    <option value="{{ $m }}"
                                                        {{ ($recapData['month'] ?? '') == $m ? 'selected' : '' }}>
                                                        {{ match ($m) {
                                                            1 => __('Januari'),
                                                            2 => __('Februari'),
                                                            3 => __('Maret'),
                                                            4 => __('April'),
                                                            5 => __('Mei'),
                                                            6 => __('Juni'),
                                                            7 => __('Juli'),
                                                            8 => __('Agustus'),
                                                            9 => __('September'),
                                                            10 => __('Oktober'),
                                                            11 => __('November'),
                                                            12 => __('Desember'),
                                                            default => '',
                                                        } }}
                                                    </option>
                                                @endforeach
                                            </x-form.select>
                                        </x-form.fieldset>
                                    </div>

                                    <div class="w-full md:w-32">
                                        <x-form.fieldset label="{{ __('Tahun') }}">
                                            <x-form.select name="year">
                                                @foreach (range(date('Y'), date('Y') - 5) as $y)
                                                    <option value="{{ $y }}"
                                                        {{ ($recapData['year'] ?? '') == $y ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endforeach
                                            </x-form.select>
                                        </x-form.fieldset>
                                    </div>
                                </div>

                                <div class="flex gap-2 pb-1">
                                    <x-button.info size="sm" type="submit" icon="search">
                                        {{ __('Lihat') }}
                                    </x-button.info>

                                    <x-button.accent size="sm" type="submit" icon="print"
                                        formaction="{{ route('issuance.print.recap') }}" formtarget="_blank">
                                        {{ __('Cetak PDF') }}
                                    </x-button.accent>
                                </div>
                            </form>
                        </x-ui.card>
                    </div>
                @endif

                {{-- Flash Messages --}}
                <x-ui.alert-session />

                @if ($tab === 'rekap')
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        {{-- Card PSE --}}
                        <x-ui.card class="shadow-none! border border-base-200">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-primary/10 rounded-xl text-primary">
                                    <x-icons.pse class="w-8 h-8" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ __('Total PSE') }}</p>
                                    <p class="text-2xl font-bold">{{ $recapData['pse'] }}</p>
                                </div>
                            </div>
                        </x-ui.card>

                        {{-- Card Subdomain --}}
                        <x-ui.card class="shadow-none! border border-base-200">
                            <div class="flex items-center gap-4">
                                <div
                                    class="p-3 bg-secondary/10 rounded-xl text-secondary dark:bg-warning/20 dark:text-warning">
                                    <x-icons.subdomain class="w-8 h-8" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ __('Total Subdomain') }}</p>
                                    <p class="text-2xl font-bold">{{ $recapData['subdomain'] }}</p>
                                </div>
                            </div>
                        </x-ui.card>

                        {{-- Card Hosting --}}
                        <x-ui.card class="shadow-none! border border-base-200">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-accent/10 rounded-xl text-accent">
                                    <x-icons.hosting class="w-8 h-8" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ __('Total Hosting') }}</p>
                                    <p class="text-2xl font-bold">{{ $recapData['hosting'] }}</p>
                                </div>
                            </div>
                        </x-ui.card>

                        {{-- Card Total --}}
                        <x-ui.card class="shadow-none! border border-base-200">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-neutral/10 rounded-xl text-base-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ __('Total Keseluruhan') }} </p>
                                    <p class="text-2xl font-bold text-base-content">{{ $recapData['total'] }}</p>
                                </div>
                            </div>
                        </x-ui.card>
                    </div>

                    <div class="mt-8 flex items-center rounded-xl border border-base-200 px-4 py-3 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="stroke-base-content/50 h-5 w-5 shrink-0 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">
                            {{ __('Klik tombol') }} <span class="text-accent font-bold">{{ __('Cetak PDF') }}</span>
                            {{ __('untuk mengunduh laporan rekapitulasi lengkap periode ini.') }}
                        </span>
                    </div>
                @elseif ($query->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <x-ui.table-sort field="updated_at" :label="__('Tanggal Penerbitan')" />
                                <x-ui.table-sort field="system_name" :label="__('Nama Sistem')" />
                                {{-- Kolom Dinamis --}}
                                @if ($tab == 'pse')
                                    <x-ui.table-sort field="registration_number" :label="__('Nomor Pendataan')" />
                                @elseif ($tab == 'subdomain')
                                    <x-ui.table-sort field="subdomain_name" :label="__('Nama Subdomain')" />
                                @elseif ($tab == 'hosting')
                                    <x-ui.table-sort field="hosting_type" :label="__('Tipe Hosting')" />
                                @endif
                                <th>{{ __('Status Keputusan') }}</th>
                                <th>{{ __('Catatan Saya') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($query as $issuance)
                                <tr>
                                    <td>{{ $loop->iteration + $query->firstItem() - 1 }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            {{ format_date_indo($issuance->approved_at) }}
                                            <span
                                                class="text-xs text-base-content/50">{{ format_time($issuance->approved_at) }}
                                                WIB</span>
                                        </div>
                                    </td>
                                    {{-- Kolom Dinamis Content --}}
                                    @if ($tab == 'pse')
                                        <td>
                                            <span class="cursor-help tooltip"
                                                data-tip="{{ $issuance->system_name }}">
                                                {{ Str::limit($issuance->system_name, 20) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="cursor-help tooltip"
                                                data-tip="{{ $issuance->registration_number }}">
                                                {{ Str::limit($issuance->registration_number, 20) }}
                                            </span>
                                        </td>
                                    @elseif($tab == 'subdomain')
                                        <td>
                                            <span class="cursor-help tooltip"
                                                data-tip="{{ $issuance->pse->system_name }}">
                                                {{ Str::limit($issuance->pse->system_name, 20) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="cursor-help tooltip"
                                                data-tip="{{ $issuance->subdomain_name }}">
                                                {{ Str::limit($issuance->subdomain_name, 20) }}
                                            </span>
                                        </td>
                                    @elseif ($tab === 'hosting')
                                        <td>
                                            <span class="cursor-help tooltip"
                                                data-tip="{{ $issuance->pse->system_name }}">
                                                {{ Str::limit($issuance->pse->system_name, 20) }}
                                            </span>
                                        </td>
                                        <td>{{ __(ucfirst($issuance->hosting_type)) }}</td>
                                    @endif

                                    <td>
                                        <x-ui.badge variant="success">{{ $issuance->status }}</x-ui.badge>
                                    </td>
                                    <td>
                                        <div class="tooltip"
                                            data-tip="{{ $issuance->verificationHistories->last()?->notes }}">
                                            <span class="text-sm text-base-content cursor-help">
                                                {{ Str::limit($issuance->verificationHistories->last()?->notes, 20) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            @if ($tab === 'pse')
                                                @can('updateRegistrationNumber', $issuance)
                                                    <x-button.warning type="button"
                                                        data-modal-show="modal_edit_pse_{{ $issuance->uuid }}"
                                                        size="sm" icon="pencil">
                                                        {{ __('Edit') }}
                                                    </x-button.warning>

                                                    {{-- Modal dengan data-auto-reset untuk auto-initialization --}}
                                                    <dialog id="modal_edit_pse_{{ $issuance->uuid }}" class="modal" @if (session('editing_pse_uuid') === $issuance->uuid) data-auto-open="true" @endif
                                                        data-auto-reset>
                                                        <div class="modal-box">
                                                            <h3 class="font-bold text-lg mb-4">
                                                                {{ __('Perbarui Nomor Pendataan PSE') }}
                                                            </h3>

                                                            <form
                                                                action="{{ route('issuance.pse.update', $issuance->uuid) }}"
                                                                method="POST" class="space-y-4 text-left">
                                                                @csrf
                                                                @method('PUT')

                                                                <x-form.fieldset label="{{ __('Nomor Pendataan PSE') }}">
                                                                    <x-form.text-input name="registration_number"
                                                                        errorBag="issuance" :errorContext="[
                                                                            'session_key' => 'editing_pse_uuid',
                                                                            'instance_id' => $issuance->uuid,
                                                                        ]"
                                                                        value="{{ session('editing_pse_uuid') === $issuance->uuid
                                                                            ? old('registration_number', $issuance->registration_number)
                                                                            : $issuance->registration_number }}"
                                                                        data-original-value="{{ $issuance->registration_number }}"
                                                                        placeholder="PSE/..." autofocus />

                                                                    <x-form.input-error :messages="$errors->issuance->has(
                                                                        'registration_number',
                                                                    ) && session('editing_pse_uuid') === $issuance->uuid
                                                                        ? $errors->issuance->get('registration_number')
                                                                        : []" />
                                                                </x-form.fieldset>

                                                                <div class="modal-action">
                                                                    {{-- Tombol Batal dengan closeAndResetModal --}}
                                                                    <x-button.ghost type="button"
                                                                        data-modal-close="modal_edit_pse_{{ $issuance->uuid }}">
                                                                        {{ __('Batal') }}
                                                                    </x-button.ghost>

                                                                    <x-button.primary type="submit">
                                                                        {{ __('Simpan') }}
                                                                    </x-button.primary>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </dialog>
                                                @endcan
                                            @endif

                                            @php
                                                $routePrefix = match ($tab) {
                                                    'pse' => 'issuance.pse.print',
                                                    'subdomain' => 'issuance.subdomain.print',
                                                    'hosting' => 'issuance.hosting.print',
                                                };
                                            @endphp
                                            <x-button.accent href="{{ route($routePrefix, $issuance->uuid) }}"
                                                size="sm" icon="print" target="_blank">{{ __('Cetak') }}
                                            </x-button.accent>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    {{-- Pagination Links --}}
                    <div class="mt-4">
                        {{ $query->appends(['tab' => $tab, 'search' => request('search')])->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                        @if (request('search'))
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <p class="text-lg font-medium">{{ __('Pencarian tidak ditemukan.') }}</p>
                            <p class="text-sm">{{ __('Tidak ada hasil untuk kata kunci') }}
                                "<strong>{{ request('search') }}</strong>"</p>
                        @else
                            <x-icons.issuance class="w-16 h-16 mb-4 opacity-50" />
                            <p class="text-lg font-medium">
                                {{ __('Belum ada riwayat verifikasi ') . __($tabName) . '.' }}</p>
                            <p class="text-sm">{{ __('Anda belum melakukan verifikasi pada kategori ini.') }}</p>
                        @endif
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>

</x-app-layout>
