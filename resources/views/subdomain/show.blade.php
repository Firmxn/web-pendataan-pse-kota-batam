@section('title', __('Detail Subdomain'))
@section('section', __('Manajemen Subdomain'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 sm:px-0">
            <x-ui.heading level="2" class="mb-0">
                {{ __('Detail Subdomain') }}
            </x-ui.heading>

            <div class="flex gap-2 w-full sm:w-auto">
                {{-- Button Ajukan (Submit) --}}
                @can('submit', $subdomain)
                    <form action="{{ route('subdomain.submit', $subdomain) }}" method="POST" class="flex-1 sm:flex-none"
                        data-confirm="{{ in_array($subdomain->pse->status, ['draft', 'rejected']) ? __('dialogs.submit_single_flow') : __('dialogs.submit_default') }}">
                        @csrf
                        @method('PATCH')
                        <x-button.success size="sm" type="submit" class="w-full">
                            {{ $subdomain->status === 'rejected' ? __('Ajukan Kembali') : __('Ajukan') }}
                        </x-button.success>
                    </form>
                @endcan

                {{-- Button Edit --}}
                @can('update', $subdomain)
                    <x-button.warning href="{{ route('subdomain.edit', $subdomain) }}" size="sm"
                        class="flex-1 sm:flex-none">
                        {{ __('Edit') }}
                    </x-button.warning>
                @endcan

                {{-- Button Kembali --}}
                <x-button.ghost href="{{ route('subdomain.index') }}" size="sm" class="flex-1 sm:flex-none">
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

                    {{-- HERO CARD: IDENTITAS PSE (SEBAGAI KONTEKS) --}}
                    <div
                        class="relative overflow-hidden bg-linear-to-br from-primary/10 via-base-100 to-base-100 rounded-4xl border border-primary/10 shadow-xl group hover:scale-[1.01] transition-all duration-300">
                        <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                            <x-icons.icon name="globe" size="32" class="text-primary" />
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
                                        {{ $subdomain->pse->system_name }}
                                    </x-ui.heading>
                                    <div class="flex items-center gap-2 text-base-content/60 mt-1">
                                        <x-icons.icon name="hash" size="4" />
                                        <span class="font-medium font-mono text-sm uppercase tracking-wider">
                                            {{ $subdomain->pse->registration_number ?? __('Belum Terbit') }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <x-display.status-badge :status="$subdomain->status"
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
                                    {{ __('Tipe Pengajuan') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ $subdomain->request_type }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="calendar" light>
                                    {{ __('Tanggal Pengajuan') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ format_date_indo($subdomain->created_at) }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="calendar" light>
                                    {{ __('Tanggal Terakhir Diperbarui') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ format_date_indo($subdomain->updated_at) }}
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- DAFTAR SUBDOMAIN (FOKUS UTAMA) --}}
                    <x-ui.card icon="layout-grid" :title="__('Daftar Subdomain Terdaftar')">
                        <div class="overflow-x-auto">
                            <table class="table table-md w-full">
                                <thead class="text-base-content/50 uppercase text-[10px] tracking-widest">
                                    <tr>
                                        <th>
                                            {{ __('Subdomain') }}
                                        </th>
                                        <th>
                                            {{ __('URL Akses') }}
                                        </th>
                                        <th class="text-center">
                                            {{ __('Status') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subdomain->pse->subdomainRequests as $sub)
                                        <tr class="hover:bg-primary/5 transition-colors group">
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="p-2 rounded-lg bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all">
                                                        <x-icons.icon name="globe" size="4" />
                                                    </div>
                                                    <span class="font-bold text-base-content">
                                                        {{ $sub->subdomain_name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ $sub->subdomain_url }}" target="_blank"
                                                    class="link link-primary link-hover flex items-center gap-1.5 text-sm font-medium">
                                                    {{ $sub->subdomain_url }}
                                                    <x-icons.icon name="external-link" size="3" />
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @if ($sub->is_primary)
                                                    <div
                                                        class="badge badge-primary font-bold text-[9px] uppercase tracking-tighter">
                                                        {{ __('Utama') }}
                                                    </div>
                                                @else
                                                    <span class="text-base-content/20 font-light italic">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <x-ui.empty-state icon="layout-grid" class="py-10">
                                                    {{ __('Belum ada subdomain yang terdaftar untuk PSE ini.') }}
                                                </x-ui.empty-state>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </x-ui.card>
                </div>

                {{-- KOLOM SAMPING (KANAN) --}}
                <div class="space-y-6">
                    {{-- INFORMASI PENANGGUNG JAWAB --}}
                    <x-ui.card icon="user" :title="__('Penanggung Jawab')">
                        <div class="space-y-6">
                            <div>
                                <x-display.text-label icon="user" light>
                                    {{ __('Nama PIC') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ $subdomain->pse->pic_name }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>
                                    {{ __('Telepon') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $subdomain->pse->pic_phone }}" target="_blank"
                                        class="link link-hover link-primary">
                                        {{ format_phone($subdomain->pse->pic_phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>
                                    {{ __('Email') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $subdomain->pse->pic_email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $subdomain->pse->pic_email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- INFORMASI PETUGAS PENDATA --}}
                    <x-ui.card icon="user" :title="__('Informasi Petugas Pendata')">
                        <div class="space-y-6">
                            <div>
                                <x-display.text-label icon="user" light>
                                    {{ __('Nama Petugas Pendata') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ $subdomain->user->name }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>
                                    {{ __('Telepon') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $subdomain->user->phone }}" target="_blank"
                                        class="link link-primary link-hover">
                                        {{ format_phone($subdomain->user->phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>
                                    {{ __('Email') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $subdomain->user->email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $subdomain->user->email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- LAMPIRAN BERKAS --}}
                    @php
                        $subdomainDocuments = $subdomain->pse->subdomainRequests
                            ->pluck('document')
                            ->filter()
                            ->unique('file_path');
                    @endphp
                    <x-ui.card icon="file-text" :title="__('Lampiran Berkas')">
                        <div class="space-y-4">
                            @forelse ($subdomainDocuments as $doc)
                                <x-display.document-card :document="$doc" :title="__('Surat Permohonan')" icon="file-text"
                                    color="primary" />
                            @empty
                                <x-ui.empty-state icon="file-text">
                                    {{ __('Tidak ada dokumen terlampir') }}
                                </x-ui.empty-state>
                            @endforelse
                        </div>
                    </x-ui.card>

                    {{-- RIWAYAT VERIFIKASI (TIMELINE) --}}
                    <x-ui.card icon="history" :title="__('Riwayat Verifikasi')">
                        @if ($subdomain->verificationHistories && $subdomain->verificationHistories->isNotEmpty())
                            <div
                                class="relative space-y-6 before:absolute before:left-4 before:top-2 before:bottom-0 before:w-0.5 before:bg-base-300/50">
                                @foreach ($subdomain->verificationHistories->sortByDesc('created_at') as $history)
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
