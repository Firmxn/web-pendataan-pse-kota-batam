@section('title', __('Profil Petugas'))
@section('section', __('Pengguna'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 sm:px-0">
            <x-ui.heading level="2">{{ __('Detail Profil Petugas') }}</x-ui.heading>
            <div class="flex items-center gap-3">
                @can('update', $user)
                    <x-button.warning href="{{ route('user.edit', $user->uuid) }}" size="sm">
                        {{ __('Edit') }}
                    </x-button.warning>
                @endcan
                <x-button.ghost href="{{ $backUrl }}" size="sm">
                    {{ __('Kembali') }}
                </x-button.ghost>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- KOLOM UTAMA --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- HERO CARD --}}
                    <div
                        class="relative overflow-hidden bg-linear-to-br from-primary/10 via-base-100 to-base-100 rounded-4xl border border-primary/10 shadow-xl group transition-all duration-300">
                        <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                            <x-icons.icon name="user" size="32" class="text-primary" />
                        </div>
                        <div class="p-8 relative">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <div
                                        class="flex items-center gap-2 text-primary text-xs font-bold tracking-widest uppercase mb-1">
                                        <x-icons.icon name="shield" size="4" />
                                        <span>{{ __('Profil Petugas') }}</span>
                                    </div>
                                    <x-ui.heading level="1">
                                        {{ $user->name }}
                                    </x-ui.heading>
                                    <div class="flex items-center gap-2 text-base-content/60 mt-1">
                                        <x-icons.icon name="hash" size="4" />
                                        <span class="font-medium text-sm tracking-wide">
                                            NIP. {{ $user->nip ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <x-ui.badge variant="primary"
                                        class="badge-lg py-5 px-6 rounded-2xl shadow-sm uppercase font-bold tracking-wider">
                                        {{ $user->role->display_name ?? $user->role->role_name }}
                                    </x-ui.badge>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- INFORMASI PEKERJAAN & INSTANSI --}}
                    <x-ui.card icon="briefcase" :title="__('Informasi Pekerjaan & Instansi')">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-6">
                            <div>
                                <x-display.text-label icon="building"
                                    light>{{ __('Organisasi Perangkat Daerah') }}</x-display.text-label>
                                <x-display.text-value>{{ $user->opd->name ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="building"
                                    light>{{ __('Tipe Instansi') }}</x-display.text-label>
                                <x-display.text-value>{{ __(ucfirst($user->opd->type ?? '-')) }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="landmark"
                                    light>{{ __('Nama Unit Kerja') }}</x-display.text-label>
                                <x-display.text-value>{{ $user->work_unit ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone"
                                    light>{{ __('Telepon Unit Kerja') }}</x-display.text-label>
                                <x-display.text-value>{{ $user->formatted_work_unit_phone ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="briefcase" light>{{ __('Jabatan') }}</x-display.text-label>
                                <x-display.text-value>{{ $user->position ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="award"
                                    light>{{ __('Status Kepegawaian') }}</x-display.text-label>
                                <x-display.text-value>{{ __(ucfirst($user->status ?? '-')) }}</x-display.text-value>
                            </div>
                            @if ($user->opd && $user->opd->email)
                                <div>
                                    <x-display.text-label icon="mail"
                                        light>{{ __('Email Resmi Instansi') }}</x-display.text-label>
                                    <x-display.text-value>
                                        <a href="mailto:{{ $user->opd->email }}"
                                            class="link link-primary text-sm font-bold">
                                            {{ $user->opd->email }}
                                        </a>
                                    </x-display.text-value>
                                </div>
                            @endif
                        </div>
                    </x-ui.card>
                </div>

                {{-- KOLOM SAMPING --}}
                <div class="space-y-6">
                    {{-- DETAIL AKUN & KONTAK --}}
                    <x-ui.card icon="layout-grid" :title="__('Detail Akun & Kontak')">
                        <div class="space-y-4">
                            <div>
                                <x-display.text-label icon="mail"
                                    light>{{ __('Email Akun') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $user->email }}"
                                        class="link link-primary link-hover truncate inline-block max-w-full lowercase">
                                        {{ $user->email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone"
                                    light>{{ __('Nomor Telepon/WA') }}</x-display.text-label>
                                <x-display.text-value>
                                    @if ($user->phone)
                                        <a href="https://wa.me/{{ $user->phone }}" target="_blank"
                                            class="link link-primary link-hover">
                                            {{ $user->formatted_phone }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="calendar"
                                    light>{{ __('Terdaftar Sejak') }}</x-display.text-label>
                                <x-display.text-value>
                                    {{ format_date_indo($user->created_at) }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="calendar"
                                    light>{{ __('Terakhir Update') }}</x-display.text-label>
                                <x-display.text-value>
                                    {{ format_date_indo($user->updated_at) }}
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- SURAT TUGAS --}}
                    <x-ui.card icon="file-text" :title="__('Surat Tugas Resmi')">
                        <div class="space-y-3">
                            @if ($user->document)
                                <x-display.document-card :document="$user->document" :title="__('Surat Tugas Petugas')" icon="file-text"
                                    color="primary" />
                            @else
                                <x-ui.empty-state icon="file-x">
                                    {{ __('Berkas surat tugas tidak tersedia.') }}
                                </x-ui.empty-state>
                            @endif
                        </div>
                    </x-ui.card>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
