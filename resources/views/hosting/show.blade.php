@section('title', __('Detail Hosting'))
@section('section', __('Manajemen Hosting'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 sm:px-0">
            <x-ui.heading level="2" class="mb-0">
                {{ __('Detail Hosting') }}
            </x-ui.heading>

            <div class="flex gap-2 w-full sm:w-auto">
                {{-- Button Ajukan (Submit) --}}
                @can('submit', $hosting)
                    <form action="{{ route('hosting.submit', $hosting) }}" method="POST" class="flex-1 sm:flex-none"
                        data-confirm="{{ in_array($hosting->pse->status, ['draft', 'rejected']) ? __('dialogs.submit_single_flow') : __('dialogs.submit_default') }}">
                        @csrf
                        @method('PATCH')
                        <x-button.success size="sm" type="submit" class="w-full">
                            {{ $hosting->status === 'rejected' ? __('Ajukan Kembali') : __('Ajukan') }}
                        </x-button.success>
                    </form>
                @endcan

                {{-- Button Edit --}}
                @can('update', $hosting)
                    <x-button.warning href="{{ route('hosting.edit', $hosting) }}" size="sm"
                        class="flex-1 sm:flex-none">
                        {{ __('Edit') }}
                    </x-button.warning>
                @endcan

                {{-- Button Kembali --}}
                <x-button.ghost href="{{ route('hosting.index') }}" size="sm" class="flex-1 sm:flex-none">
                    {{ __('Kembali') }}
                </x-button.ghost>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- KOLOM UTAMA (KIRI) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- HERO CARD: IDENTITAS PSE --}}
                    <div
                        class="relative overflow-hidden bg-linear-to-br from-primary/10 via-base-100 to-base-100 rounded-4xl border border-primary/10 shadow-xl group hover:scale-[1.01] transition-all duration-300">
                        <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                            <x-icons.icon name="cpu" size="32" class="text-primary" />
                        </div>

                        <div class="p-8 relative">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <div
                                        class="flex items-center gap-2 text-primary text-xs font-bold tracking-widest uppercase mb-1">
                                        <x-icons.icon name="cpu" size="4" />
                                        <span>
                                            {{ __('Sistem Elektronik') }}
                                        </span>
                                    </div>
                                    <x-ui.heading level="1">
                                        {{ $hosting->pse->system_name }}
                                    </x-ui.heading>
                                    <div class="flex items-center gap-2 text-base-content/60 mt-1">
                                        <x-icons.icon name="hash" size="4" />
                                        <span class="font-medium font-mono text-sm uppercase tracking-wider">
                                            {{ $hosting->pse->registration_number ?? __('Belum Terbit') }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <x-display.status-badge :status="$hosting->status"
                                        class="badge-lg py-5 px-6 rounded-2xl shadow-sm" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- INFORMASI PENGAJUAN (METADATA) --}}
                    <x-ui.card icon="info" :title="__('Informasi Pengajuan')">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-1">
                            <div>
                                <x-display.text-label icon="send" light>
                                    {{ __('Jenis Pengajuan') }}
                                </x-display.text-label>
                                <x-display.text-value class="capitalize">
                                    {{ $hosting->request_type }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="calendar" light>
                                    {{ __('Tanggal Pengajuan') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ format_date_indo($hosting->created_at) }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="calendar" light>
                                    {{ __('Tanggal Terakhir Diperbarui') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ format_date_indo($hosting->updated_at) }}
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- DETAIL HOSTING & SPESIFIKASI --}}
                    <x-ui.card icon="cpu" :title="__('Spesifikasi & Detail Hosting')">
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                    <x-display.text-label light class="text-[10px]">
                                        {{ __('CPU') }}
                                    </x-display.text-label>
                                    <p class="font-bold text-lg text-base-content mt-1">
                                        {{ $hosting->cpu_cores }}
                                        Cores</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                    <x-display.text-label light class="text-[10px]">
                                        {{ __('RAM') }}
                                    </x-display.text-label>
                                    <p class="font-bold text-lg text-base-content mt-1">
                                        {{ $hosting->ram_capacity }} GB</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                    <x-display.text-label light class="text-[10px]">
                                        {{ __('Storage') }}
                                    </x-display.text-label>
                                    <p class="font-bold text-lg text-base-content mt-1">
                                        {{ $hosting->storage_capacity }} GB</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                    <x-display.text-label light class="text-[10px]">
                                        {{ __('Bandwidth') }}
                                    </x-display.text-label>
                                    <p class="font-bold text-lg text-base-content mt-1">
                                        {{ $hosting->bandwidth_capacity >= 1000 ? $hosting->bandwidth_capacity / 1000 . ' TB' : $hosting->bandwidth_capacity . ' GB' }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-display.text-label icon="cpu" light>
                                        {{ __('Tipe Layanan') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ $hosting->hosting_type }}
                                    </x-display.text-value>
                                </div>
                                <div>
                                    <x-display.text-label icon="send" light>
                                        {{ __('Jenis Pengajuan') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ $hosting->request_type }}
                                    </x-display.text-value>
                                </div>
                            </div>
                            <div>
                                <x-display.text-label icon="sticky-note" light>
                                    {{ __('Catatan Kebutuhan Khusus') }}
                                </x-display.text-label>
                                <x-display.text-value class="font-normal text-justify leading-relaxed">
                                    {!! nl2br(e($hosting->notes ?? __('Tidak ada catatan.'))) !!}
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                </div>

                {{-- KOLOM SAMPING (KANAN) --}}
                <div class="space-y-6">

                    {{-- INFORMASI PIC --}}
                    <x-ui.card icon="user" :title="__('Penanggung Jawab')">
                        <div class="space-y-6">
                            <div>
                                <x-display.text-label icon="user" light>
                                    {{ __('Nama PIC') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ $hosting->pse->pic_name }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>
                                    {{ __('Telepon') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $hosting->pse->pic_phone }}" target="_blank"
                                        class="link link-hover link-primary">
                                        {{ format_phone($hosting->pse->pic_phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>
                                    {{ __('Email') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $hosting->pse->pic_email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $hosting->pse->pic_email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- INFORMASI PETUGAS PENDATA --}}
                    <x-ui.card icon="layout-grid" :title="__('Petugas Pendata')">
                        <div class="space-y-6">
                            <div>
                                <x-display.text-label icon="user" light>
                                    {{ __('Nama Petugas') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ $hosting->user->name }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>
                                    {{ __('Email') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $hosting->user->email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $hosting->user->email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- LAMPIRAN BERKAS --}}
                    @php
                        $subdomainDocs = $hosting->pse->subdomainRequests
                            ->pluck('document')
                            ->filter()
                            ->unique('file_path');
                        $anySdoc = $subdomainDocs->isNotEmpty();
                    @endphp
                    <x-ui.card icon="file-text" :title="__('Lampiran Berkas')">
                        <div class="space-y-4">
                            @if ($hosting->document)
                                <x-display.document-card :document="$hosting->document" :title="__('Surat Permohonan Hosting')" icon="file-text"
                                    color="primary" />
                            @endif

                            @if ($hosting->pse->storage_location === 'aplikasi' && $anySdoc)
                                @foreach ($subdomainDocs as $doc)
                                    <x-display.document-card :document="$doc" :title="__('Surat Permohonan Subdomain (Paket)')"
                                        icon="globe" color="primary" />
                                @endforeach
                            @endif

                            @if (!$hosting->document && (!$anySdoc || $hosting->pse->storage_location !== 'aplikasi'))
                                <x-ui.empty-state icon="file-text">
                                    {{ __('Tidak ada dokumen terlampir') }}
                                </x-ui.empty-state>
                            @endif
                        </div>
                    </x-ui.card>

                    {{-- RIWAYAT VERIFIKASI (TIMELINE) --}}
                    <x-ui.card icon="history" :title="__('Riwayat Verifikasi')">
                        @if ($hosting->verificationHistories && $hosting->verificationHistories->isNotEmpty())
                            <div
                                class="relative space-y-6 before:absolute before:left-4 before:top-2 before:bottom-0 before:w-0.5 before:bg-base-300/50">
                                @foreach ($hosting->verificationHistories->sortByDesc('created_at') as $history)
                                    <div class="relative pl-10 group">
                                        {{-- Dot --}}
                                        <div class="absolute left-0 top-1.5 w-8 h-8 flex items-center justify-center">
                                            <div
                                                class="w-3 h-3 rounded-full border-2 border-base-100 {{ status_bg_color($history->status) }} ring-4 ring-base-200 shadow-sm transition-all group-hover:scale-125">
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex items-center justify-between gap-2">
                                                <x-display.status-badge :status="$history->status" size="xs" />
                                                <span
                                                    class="text-[10px] text-base-content/40 font-medium uppercase font-mono">
                                                    {{ $history->created_at->translatedFormat('d M H:i') }}
                                                </span>
                                            </div>
                                            <p class="text-xs font-bold text-base-content mt-2">
                                                {{ $history->user->name }}
                                            </p>
                                            @if ($history->notes)
                                                <div
                                                    class="mt-2 p-3 rounded-xl bg-base-200/50 border border-base-300/30">
                                                    <p class="text-[11px] text-base-content/70 italic leading-relaxed">
                                                        "{{ $history->notes }}"
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <x-ui.empty-state icon="history">
                                {{ __('Belum ada riwayat verifikasi') }}
                            </x-ui.empty-state>
                        @endif
                    </x-ui.card>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
