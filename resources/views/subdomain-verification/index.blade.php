@php
    $isFinal = request()->routeIs('subdomain-verification2.*');
    $routePrefix = $isFinal ? 'subdomain-verification2' : 'subdomain-verification';
@endphp

@section('title', $isFinal ? __('Verifikasi Final') : __('Verifikasi'))
@section('section', __('Subdomain'))

<x-app-layout>
    <x-slot name="header">
        <x-ui.heading level="2">
            {{ $isFinal ? __('Verifikasi Subdomain - Final') : __('Verifikasi Subdomain - Tingkat 1') }}
        </x-ui.heading>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />

            <x-ui.card>
                <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 mb-4">
                    <div class="flex-1 max-w-sm">
                        <x-form.search-input action="{{ route($routePrefix . '.index') }}" value="{{ request('search') }}"
                            placeholder="{{ __('Cari Subdomain, Sistem, atau OPD...') }}" />
                    </div>
                </div>

                @if ($subdomains->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <x-ui.table-sort field="system_name" :label="__('Nama Sistem')" />
                                <x-ui.table-sort field="name" :label="__('OPD')" />
                                <x-ui.table-sort field="request_type" :label="__('Tipe Pengajuan')" />
                                <x-ui.table-sort field="subdomain_name" :label="__('Nama Subdomain')" />
                                <x-ui.table-sort field="created_at" :label="__('Tanggal Ajuan')" />
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($subdomains as $subdomain)
                                <tr class="hover:bg-base-200">
                                    <td>{{ $subdomains->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $subdomain->pse->system_name }}">
                                            <span
                                                class="cursor-help">{{ Str::limit($subdomain->pse->system_name, 25) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $subdomain->pse->opd->name ?? '-' }}">
                                            <span
                                                class="cursor-help">{{ Str::limit($subdomain->pse->opd->name ?? '-', 25) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <x-display.request-type-badge :type="$subdomain->request_type" />
                                    </td>
                                    <td>{{ $subdomain->subdomain_name }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            {{ format_date_indo($subdomain->created_at) }}
                                            <span
                                                class="text-xs text-base-content/50">{{ format_time($subdomain->created_at) }}
                                                WIB</span>
                                        </div>
                                    </td>
                                    <td>
                                        <x-button.primary href="{{ route($routePrefix . '.show', $subdomain) }}"
                                            size="sm">
                                            {{ __('Verifikasi') }}
                                        </x-button.primary>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    <div class="mt-4">
                        {{ $subdomains->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                        @if (request('search'))
                            <p class="mb-4">{{ __('Tidak ditemukan data verifikasi subdomain dengan kata kunci') }}
                                "<strong>{{ request('search') }}</strong>".
                            </p>
                            <x-button.ghost href="{{ route($routePrefix . '.index') }}">
                                {{ __('Reset Pencarian') }}
                            </x-button.ghost>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                            <p class="text-lg font-medium">
                                {{ __('Belum ada permintaan subdomain yang menunggu verifikasi.') }}
                            </p>
                            <p class="text-sm">{{ __('Anda belum dapat melakukan verifikasi pada kategori ini.') }}</p>
                        @endif
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
