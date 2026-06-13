@php
    $isFinal = request()->routeIs('hosting-verification2.*');
    $routePrefix = $isFinal ? 'hosting-verification2' : 'hosting-verification';
@endphp

@section('title', $isFinal ? __('Verifikasi Final') : __('Verifikasi'))
@section('section', __('Hosting'))

<x-app-layout>
    <x-slot name="header">
        <x-ui.heading level="2">
            {{ $isFinal ? __('Verifikasi Hosting - Final') : __('Verifikasi Hosting - Tingkat 1') }}
        </x-ui.heading>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />

            <x-ui.card>
                <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 mb-4">
                    <div class="flex-1 max-w-sm">
                        <x-form.search-input action="{{ route($routePrefix . '.index') }}" value="{{ request('search') }}"
                            placeholder="{{ __('Cari Sistem atau OPD...') }}" />
                    </div>
                </div>

                @if ($hostings->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <x-ui.table-sort field="system_name" :label="__('Nama Sistem')" />
                                <x-ui.table-sort field="name" :label="__('OPD')" />
                                <th>{{ __('Petugas') }}</th>
                                <x-ui.table-sort field="request_type" :label="__('Tipe Pengajuan')" />
                                <x-ui.table-sort field="hosting_type" :label="__('Tipe Hosting')" />
                                <x-ui.table-sort field="created_at" :label="__('Tanggal Ajuan')" />
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($hostings as $hosting)
                                <tr class="hover:bg-base-200">
                                    <td>{{ $hostings->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $hosting->pse->system_name }}">
                                            <span
                                                class="cursor-help">{{ Str::limit($hosting->pse->system_name, 25) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $hosting->pse->opd->name ?? '-' }}">
                                            <span
                                                class="cursor-help">{{ Str::limit($hosting->pse->opd->name ?? '-', 25) }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $hosting->user->name }}</td>
                                    <td>
                                        <x-display.request-type-badge :type="$hosting->request_type" />
                                    </td>
                                    <td>{{ ucfirst($hosting->hosting_type) }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            {{ format_date_indo($hosting->created_at) }}
                                            <span
                                                class="text-xs text-base-content/50">{{ format_time($hosting->created_at) }}
                                                WIB</span>
                                        </div>
                                    </td>
                                    <td>
                                        <x-button.primary href="{{ route($routePrefix . '.show', $hosting) }}"
                                            size="sm">
                                            {{ __('Verifikasi') }}
                                        </x-button.primary>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    <div class="mt-4">
                        {{ $hostings->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                        @if (request('search'))
                            <p class="mb-4">{{ __('Tidak ditemukan data verifikasi hosting dengan kata kunci') }}
                                "<strong>{{ request('search') }}</strong>".
                            </p>
                            <x-button.ghost href="{{ route($routePrefix . '.index') }}">
                                {{ __('Reset Pencarian') }}
                            </x-button.ghost>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z" />
                            </svg>
                            <p class="text-lg font-medium">
                                {{ __('Belum ada permintaan hosting yang menunggu verifikasi.') }}
                            </p>
                            <p class="text-sm">{{ __('Anda belum dapat melakukan verifikasi pada kategori ini.') }}</p>
                        @endif
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
