@section('title', __('Detail'))
@section('section', __('PSE'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <x-ui.heading level="2">
                {{ __('Detail PSE') }}
            </x-ui.heading>
            <div class="flex gap-2">
                {{-- Button Ajukan (Submit) --}}
                @can('submit', $pse)
                    <form action="{{ route('pse.submit', $pse) }}" method="POST"
                        data-confirm="{{ __('dialogs.submit_pse') }}">
                        @csrf
                        @method('PATCH')
                        <x-button.success size="sm" type="submit">
                            {{ $pse->status === 'rejected' ? __('Ajukan Kembali') : __('Ajukan') }}
                        </x-button.success>
                    </form>
                @endcan

                {{-- Button Edit --}}
                @can('update', $pse)
                    <x-button.warning href="{{ route('pse.edit', $pse) }}" size="sm">
                        {{ __('Edit') }}
                    </x-button.warning>
                @endcan

                {{-- Button Kembali --}}
                <x-button.ghost href="{{ route('pse.index') }}" size="sm">
                    {{ __('Kembali') }}
                </x-button.ghost>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- KOLOM UTAMA (KIRI/TENGAH) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- HERO CARD: IDENTITAS UTAMA PSE --}}
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
                                        {{ $pse->system_name }}
                                    </x-ui.heading>
                                    <div class="flex items-center gap-2 text-base-content/60 mt-1">
                                        <x-icons.icon name="hash" size="4" />
                                        <span class="font-medium font-mono text-sm uppercase tracking-wider">
                                            {{ $pse->registration_number ?? __('Belum Terbit') }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <x-display.status-badge :status="$pse->status"
                                        class="badge-lg py-5 px-6 rounded-2xl shadow-sm" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DETAIL SISTEM & DESKRIPSI --}}
                    <x-ui.card icon="info" :title="__('Informasi Sistem')">
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-display.text-label icon="shapes" light>
                                        {{ __('Sektor') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ $pse->sector_label }}
                                    </x-display.text-value>
                                </div>
                                <div>
                                    <x-display.text-label icon="building" light>
                                        {{ __('OPD Pengelola') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ $pse->opd->name ?? '-' }}
                                    </x-display.text-value>
                                </div>
                                <div>
                                    <x-display.text-label icon="database" light>
                                        {{ __('Lokasi Penyimpanan Data') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ $pse->storage_location }}
                                    </x-display.text-value>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-display.text-label icon="calendar" light>
                                        {{ __('Tanggal Pendataan') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ format_date_indo($pse->created_at) }}
                                    </x-display.text-value>
                                </div>
                                <div>
                                    <x-display.text-label icon="calendar" light>
                                        {{ __('Tanggal Terakhir Diperbarui') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ format_date_indo($pse->updated_at) }}
                                    </x-display.text-value>
                                </div>
                            </div>

                            <div>
                                <x-display.text-label icon="align-left" light>
                                    {{ __('Deskripsi Sistem') }}
                                </x-display.text-label>
                                <x-display.text-value class="font-normal text-justify leading-relaxed">
                                    {!! nl2br(e($pse->description ?? __('Tidak ada deskripsi sistem.'))) !!}
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>


                    {{-- KLASIFIKASI DATA & RISIKO --}}
                    <x-ui.card icon="shield-check" :title="__('Keamanan & Risiko')">
                        <div class="space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-display.text-label icon="alert-triangle" light>
                                        {{ __('Risiko') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ __($pse->risk_category) }}
                                    </x-display.text-value>
                                </div>
                                <div>
                                    <x-display.text-label icon="lock" light>
                                        {{ __('Data') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ __($pse->data_classification) }}
                                    </x-display.text-value>
                                </div>
                            </div>

                            <div>
                                <x-display.text-label icon="database" light>
                                    {{ __('Informasi Data Pribadi') }}
                                </x-display.text-label>
                                <x-display.text-value class="font-normal text-justify leading-relaxed">
                                    {!! nl2br(e($pse->private_data_info ?? __('Tidak mengelola data pribadi.'))) !!}
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- DAFTAR SUBDOMAIN --}}
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
                                    @forelse($pse->subdomainRequests as $sub)
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
                                            <td colspan="3" class="text-center py-8 text-base-content/40 italic">
                                                {{ __('Belum ada subdomain yang terdaftar untuk PSE ini.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </x-ui.card>

                    {{-- DETAIL HOSTING (Kondisional) --}}
                    @if ($pse->storage_location === 'aplikasi' && $pse->hostingRequests->isNotEmpty())
                        @php $hosting = $pse->hostingRequests->first(); @endphp
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
                    @endif
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
                                    {{ $pse->pic_name }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>
                                    {{ __('Telepon') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $pse->pic_phone }}" target="_blank"
                                        class="link link-hover link-primary">
                                        {{ format_phone($pse->pic_phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>
                                    {{ __('Email') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $pse->pic_email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $pse->pic_email }}
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
                                    {{ $pse->user->name }}
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>
                                    {{ __('Telepon') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $pse->user->phone }}" target="_blank"
                                        class="link link-primary link-hover">
                                        {{ format_phone($pse->user->phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>
                                    {{ __('Email') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $pse->user->email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $pse->user->email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- LAMPIRAN BERKAS (SINGLE FLOW) --}}
                    <x-ui.card icon="file-text" :title="__('Lampiran Berkas')">
                        <div class="space-y-3">
                            @php
                                $subdomainDocs = $pse->subdomainRequests
                                    ->pluck('document')
                                    ->filter()
                                    ->unique('file_path');
                                $hostingDoc =
                                    $pse->storage_location === 'aplikasi'
                                        ? $pse->hostingRequests->first()?->document
                                        : null;
                                $anyDocument = $subdomainDocs->isNotEmpty() || $hostingDoc;
                            @endphp

                            @if ($anyDocument)
                                {{-- Surat Subdomain --}}
                                @foreach ($subdomainDocs as $doc)
                                    <x-display.document-card :document="$doc" :title="__('Surat Subdomain')" icon="database"
                                        color="primary" />
                                @endforeach

                                {{-- Surat Hosting --}}
                                <x-display.document-card :document="$hostingDoc" :title="__('Surat Hosting')" icon="cpu"
                                    color="accent" />
                            @else
                                <x-ui.empty-state icon="file-text">
                                    {{ __('Tidak ada dokumen terlampir') }}
                                </x-ui.empty-state>
                            @endif
                        </div>
                    </x-ui.card>

                    {{-- RIWAYAT VERIFIKASI (TIMELINE) --}}
                    <x-ui.card icon="history" :title="__('Riwayat Verifikasi')">
                        @if ($pse->verificationHistories && $pse->verificationHistories->isNotEmpty())
                            <div
                                class="relative space-y-6 before:absolute before:left-4 before:top-2 before:bottom-0 before:w-0.5 before:bg-base-300/50">
                                @foreach ($pse->verificationHistories->sortByDesc('created_at') as $history)
                                    <div class="relative pl-10 group">
                                        <div
                                            class="absolute left-0 top-1 w-8 h-8 rounded-full border-4 border-base-100 {{ status_bg_color($history->status) }} shadow-sm z-10">
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="text-[10px] font-bold text-base-content/40 uppercase">
                                                    {{ format_date($history->created_at) }}
                                                </span>
                                                <x-display.status-badge :status="$history->status" class="badge-xs scale-75" />
                                            </div>
                                            <p class="text-sm font-bold text-base-content">
                                                {{ $history->user->name }}
                                            </p>
                                            @if ($history->notes)
                                                <div class="bg-base-200/50 p-2 rounded-xl mt-2">
                                                    <p class="text-xs text-base-content/60 italic">
                                                        {{ $history->notes }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <x-ui.empty-state icon="history">
                                {{ __('Belum ada riwayat verifikasi.') }}
                            </x-ui.empty-state>
                        @endif
                    </x-ui.card>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
