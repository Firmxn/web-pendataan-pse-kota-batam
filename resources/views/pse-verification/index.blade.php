@php
    $isFinal = request()->routeIs('pse-verification2.*');
    $routePrefix = $isFinal ? 'pse-verification2' : 'pse-verification';
@endphp

@section('title', $isFinal ? __('Verifikasi Final') : __('Verifikasi'))
@section('section', __('PSE'))

<x-app-layout>
    <x-slot name="header">
        <x-ui.heading level="2">
            {{ $isFinal ? __('Verifikasi PSE - Final') : __('Verifikasi PSE - Tingkat 1') }}
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

                @if ($pses->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <x-ui.table-sort field="system_name" :label="__('Nama Sistem')" />
                                <x-ui.table-sort field="name" :label="__('OPD')" />
                                <th>{{ __('Petugas') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Nomor Telepon') }}</th>
                                <x-ui.table-sort field="created_at" :label="__('Tanggal Ajuan')" />
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($pses as $pse)
                                <tr class="hover:bg-base-200">
                                    <td>{{ $pses->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $pse->system_name }}">
                                            <span class="cursor-help">{{ Str::limit($pse->system_name, 20) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $pse->opd->name ?? '-' }}">
                                            <span
                                                class="cursor-help">{{ Str::limit($pse->opd->name ?? '-', 20) }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $pse->user->name }}</td>
                                    <td>
                                        <a href="mailto:{{ $pse->user->email }}" class="link link-primary link-hover">
                                            {{ $pse->user->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="https://wa.me/{{ $pse->user->phone }}" target="_blank"
                                            class="link link-primary link-hover">
                                            {{ $pse->user->formatted_phone }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="flex flex-col">
                                            {{ format_date_indo($pse->created_at) }}
                                            <span
                                                class="text-xs text-base-content/50">{{ format_time($pse->created_at) }}
                                                WIB</span>
                                        </div>
                                    </td>
                                    <td>
                                        <x-button.primary href="{{ route($routePrefix . '.show', $pse) }}"
                                            size="sm">
                                            {{ __('Verifikasi') }}
                                        </x-button.primary>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    <div class="mt-4">
                        {{ $pses->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                        @if (request('search'))
                            <p class="mb-4">{{ __('Tidak ditemukan data verifikasi PSE dengan kata kunci') }}
                                "<strong>{{ request('search') }}</strong>".
                            </p>
                            <x-button.ghost href="{{ route($routePrefix . '.index') }}">
                                {{ __('Reset Pencarian') }}
                            </x-button.ghost>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S12 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S12 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                            <p class="text-lg font-medium">
                                {{ __('Belum ada pendataan PSE yang menunggu verifikasi.') }}
                            </p>
                            <p class="text-sm">{{ __('Anda belum dapat melakukan verifikasi pada kategori ini.') }}</p>
                        @endif
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
