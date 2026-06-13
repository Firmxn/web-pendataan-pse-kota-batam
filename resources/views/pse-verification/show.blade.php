@php
    $isFinal = request()->routeIs('pse-verification2.*');
    $routePrefix = $isFinal ? 'pse-verification2' : 'pse-verification';
@endphp

@section('title', $isFinal ? __('Verifikasi Final') : __('Verifikasi'))
@section('section', __('PSE'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <x-ui.heading level="2">
                {{ $isFinal ? __('Verifikasi PSE - Final') : __('Verifikasi PSE') }}
            </x-ui.heading>
            <div class="flex gap-2">
                <x-button.ghost href="{{ route($routePrefix . '.index') }}" size="sm">
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
                        class="relative overflow-hidden bg-linear-to-br from-primary/10 via-base-100 to-base-100 rounded-4xl border border-primary/10 shadow-xl group transition-all duration-300">
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
                                    <x-display.text-label icon="database" light>
                                        {{ __('Lokasi Penyimpanan Data') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ $pse->storage_location_label }}
                                    </x-display.text-value>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-display.text-label icon="calendar" light>
                                        {{ __('Tanggal Pengajuan') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ format_date_indo($pse->created_at) }}
                                    </x-display.text-value>
                                </div>
                                <div>
                                    <x-display.text-label icon="lock" light>
                                        {{ __('Klasifikasi Data') }}
                                    </x-display.text-label>
                                    <x-display.text-value>
                                        {{ __($pse->data_classification) }}
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

                    {{-- KEAMANAN & RISIKO --}}
                    <x-ui.card icon="shield-check" :title="__('Keamanan & Risiko')">
                        <div class="space-y-5">
                            <div>
                                <x-display.text-label icon="alert-triangle" light>
                                    {{ __('Kategori Risiko') }}
                                </x-display.text-label>
                                <x-display.text-value>
                                    {{ __($pse->risk_category) }}
                                </x-display.text-value>
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
                                        <th>{{ __('Subdomain') }}</th>
                                        <th>{{ __('URL Akses') }}</th>
                                        <th class="text-center">{{ __('Status') }}</th>
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
                                            {{ $hosting->cpu_cores }} Cores
                                        </p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                        <x-display.text-label light class="text-[10px]">
                                            {{ __('RAM') }}
                                        </x-display.text-label>
                                        <p class="font-bold text-lg text-base-content mt-1">
                                            {{ $hosting->ram_capacity }} GB
                                        </p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                        <x-display.text-label light class="text-[10px]">
                                            {{ __('Storage') }}
                                        </x-display.text-label>
                                        <p class="font-bold text-lg text-base-content mt-1">
                                            {{ $hosting->storage_capacity }} GB
                                        </p>
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
                                            {{ __('Status Hosting') }}
                                        </x-display.text-label>
                                        <x-display.status-badge :status="$hosting->status" />
                                    </div>
                                </div>
                                <div>
                                    <x-display.text-label icon="sticky-note" light>
                                        {{ __('Catatan Hosting') }}
                                    </x-display.text-label>
                                    <x-display.text-value class="font-normal text-justify leading-relaxed">
                                        {!! nl2br(e($hosting->notes ?? __('Tidak ada catatan.'))) !!}
                                    </x-display.text-value>
                                </div>
                            </div>
                        </x-ui.card>
                    @endif

                    {{-- FORMULIR VERIFIKASI (Tampil sesuai status dan rute) --}}
                    @if (($isFinal && $pse->status === 'pending_2') || (!$isFinal && $pse->status === 'pending_1'))
                        <x-ui.card icon="check-square" :title="$isFinal ? __('Verifikasi Final') : __('Verifikasi Pengajuan')">
                            <div class="space-y-8">
                                {{-- Section Setujui --}}
                                <div class="p-6 rounded-3xl bg-success/5 border border-success/10 space-y-4">
                                    <div class="flex items-center gap-3 text-success">
                                        <h4 class="font-bold text-lg">
                                            {{ $isFinal ? __('Setujui & Terbitkan Nomor Pendataan PSE') : __('Setujui Pengajuan') }}
                                        </h4>
                                    </div>
                                    @if (!$isFinal)
                                        <p class="text-sm text-base-content/60">
                                            {{ __('Gunakan opsi ini jika data sudah valid dan layak untuk diteruskan ke Tahap 2.') }}
                                        </p>
                                    @endif

                                    <form method="POST" action="{{ route($routePrefix . '.approve', $pse) }}" data-confirm="{{ $isFinal ? __('dialogs.approve_pse_v2') : __('dialogs.approve_pse_v1') }}"
                                        class="space-y-5">
                                        @csrf
                                        @method('PATCH')

                                        @if ($isFinal)
                                            <x-form.fieldset :label="__('Nomor Pendataan PSE (Wajib)')">
                                                <x-form.text-input name="registration_number" type="text"
                                                    :value="old('registration_number')" placeholder="{{ __('Contoh: PSE/2025/001') }}"
                                                    autofocus />
                                                <x-form.input-error :messages="$errors->get('registration_number')" />
                                                <x-form.input-description
                                                    value="{{ __('Nomor ini akan dicetak pada tanda bukti pendaftaran.') }}" />
                                            </x-form.fieldset>
                                        @endif

                                        <x-form.fieldset :label="$isFinal
                                            ? __('Catatan Persetujuan (Opsional)')
                                            : __('Catatan Persetujuan (Opsional)')">
                                            <x-form.textarea name="notes" rows="2"
                                                placeholder="{{ $isFinal ? __('Tambahkan catatan untuk pemohon...') : __('Tambahkan instruksi jika ada...') }}">{{ old('notes') }}</x-form.textarea>
                                            <x-form.input-error :messages="$errors->get('notes')" />
                                        </x-form.fieldset>

                                        <div class="flex justify-end">
                                            <x-button.success size="sm" icon="check" type="submit">
                                                {{ $isFinal ? __('Terbitkan & Selesaikan') : __('Setujui & Teruskan') }}
                                            </x-button.success>
                                        </div>
                                    </form>
                                </div>

                                <div
                                    class="divider text-base-content/20 text-[10px] font-bold tracking-widest uppercase">
                                    {{ __('Atau') }}
                                </div>

                                {{-- Section Tolak --}}
                                <div class="p-6 rounded-3xl bg-error/5 border border-error/10 space-y-4">
                                    <div class="flex items-center gap-3 text-error">
                                        <x-icons.icon name="x-circle" size="6" />
                                        <h4 class="font-bold text-lg">
                                            {{ $isFinal ? __('Tolak Verifikasi Final') : __('Tolak Pengajuan') }}
                                        </h4>
                                    </div>
                                    @if (!$isFinal)
                                        <p class="text-sm text-base-content/60">
                                            {{ __('Gunakan opsi ini jika terdapat data yang salah atau berkas yang tidak valid.') }}
                                        </p>
                                    @endif

                                    <form method="POST" action="{{ route($routePrefix . '.reject', $pse) }}" data-confirm="{{ __('dialogs.reject_pse') }}"
                                        class="space-y-4">
                                        @csrf
                                        @method('PATCH')
                                        <x-form.fieldset :label="__('Alasan Penolakan (Wajib)')">
                                            <x-form.textarea name="notes" rows="3" required
                                                placeholder="{{ $isFinal ? __('Jelaskan alasan penolakan final...') : __('Sebutkan poin-poin yang perlu diperbaiki...') }}">{{ old('notes') }}</x-form.textarea>
                                            <x-form.input-error :messages="$errors->get('notes')" />
                                            @if (!$isFinal)
                                                <x-form.input-description
                                                    value="{{ __('Catatan ini akan langsung tampil di dashboard petugas pendata.') }}" />
                                            @endif
                                        </x-form.fieldset>
                                        <div class="flex justify-end">
                                            <x-button.error size="sm" icon="x" type="submit">
                                                {{ $isFinal ? __('Tolak Pengajuan') : __('Tolak & Minta Perbaikan') }}
                                            </x-button.error>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </x-ui.card>
                    @endif

                </div>

                {{-- KOLOM SAMPING (KANAN) --}}
                <div class="space-y-6">

                    {{-- ALERT STATUS --}}
                    @if ($isFinal)
                        @if ($pse->status === 'pending_2')
                            <x-ui.alert variant="info">
                                {{ __('messages.pse.verify2_info_pending') }}
                            </x-ui.alert>
                        @elseif ($pse->status === 'approved')
                            <x-ui.alert variant="primary">
                                {{ __('messages.pse.verify2_info_approved') }}
                            </x-ui.alert>
                        @endif
                    @endif

                    {{-- ALERT SINGLE FLOW --}}
                    @if ($pse->storage_location === 'aplikasi' && in_array($pse->status, ['pending_1', 'pending_2']))
                        <x-ui.alert variant="warning">
                            <div class="space-y-1">
                                <p class="font-bold text-sm">{{ __('messages.single_flow.title') }}</p>
                                <p class="text-xs leading-relaxed opacity-90">
                                    {{ __('messages.single_flow.info_pse') }}
                                    @if ($isFinal)
                                        <br><span
                                            class="font-bold underline italic">{{ __('messages.single_flow.v2_note') }}</span>
                                    @else
                                        <br>{{ __('messages.single_flow.v1_note') }}
                                    @endif
                                </p>
                            </div>
                        </x-ui.alert>
                    @endif

                    {{-- INFORMASI OPD --}}
                    <x-ui.card icon="building" :title="__('Informasi OPD')">
                        <div class="space-y-6">
                            <div>
                                <x-display.text-label icon="building"
                                    light>{{ __('Nama OPD') }}</x-display.text-label>
                                <x-display.text-value>{{ $pse->opd->name ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="building" light>{{ __('Tipe') }}</x-display.text-label>
                                <x-display.text-value>{{ $pse->opd->type ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="building" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $pse->opd->email ?? '-' }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $pse->opd->email ?? '-' }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- INFORMASI PETUGAS PENDATA --}}
                    <x-ui.card icon="user" :title="__('Informasi Petugas Pendata')">
                        <div class="space-y-6">
                            <div>
                                <x-display.text-label icon="user"
                                    light>{{ __('Nama Petugas Pendata') }}</x-display.text-label>
                                <x-display.text-value>{{ $pse->user->name }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>{{ __('Telepon') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $pse->user->phone }}" target="_blank"
                                        class="link link-primary link-hover">
                                        {{ format_phone($pse->user->phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $pse->user->email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $pse->user->email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div class="pt-2">
                                <x-button.ghost href="{{ route('user.show', $pse->user) }}" size="sm"
                                    class="w-full text-[10px] uppercase tracking-wider" icon="user">
                                    {{ __('Lihat Profil Lengkap') }}
                                </x-button.ghost>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- INFORMASI PENANGGUNG JAWAB --}}
                    <x-ui.card icon="user" :title="__('Informasi Penanggung Jawab')">
                        <div class="space-y-6">
                            <div>
                                <x-display.text-label icon="user" light>{{ __('Nama PIC') }}</x-display.text-label>
                                <x-display.text-value>{{ $pse->pic_name }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>{{ __('Telepon') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $pse->pic_phone }}" target="_blank"
                                        class="link link-hover link-primary">
                                        {{ format_phone($pse->pic_phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $pse->pic_email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $pse->pic_email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- DOKUMEN --}}
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
                                $officerDoc = $pse->user->document;
                                $anyDocument = $subdomainDocs->isNotEmpty() || $hostingDoc || $officerDoc;
                            @endphp

                            @if ($anyDocument)
                                {{-- Surat Subdomain --}}
                                @foreach ($subdomainDocs as $doc)
                                    <x-display.document-card :document="$doc" :title="__('Surat Subdomain')" icon="globe"
                                        color="primary" />
                                @endforeach

                                {{-- Surat Hosting --}}
                                <x-display.document-card :document="$hostingDoc" :title="__('Surat Hosting')" icon="cpu"
                                    color="accent" />

                                {{-- Surat Petugas --}}
                                <x-display.document-card :document="$officerDoc" :title="__('Surat Petugas')" icon="file-text"
                                    color="secondary" />
                            @else
                                <x-ui.empty-state icon="file-text" size="8">
                                    {{ __('Tidak ada dokumen') }}
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
                                            <p class="text-sm font-bold text-base-content">{{ $history->user->name }}
                                            </p>
                                            @if ($history->notes)
                                                <div class="bg-base-200/50 p-2 rounded-xl mt-2">
                                                    <p class="text-xs text-base-content/60 italic">
                                                        "{{ $history->notes }}"</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <x-ui.empty-state icon="history" size="8">
                                {{ __('Belum ada riwayat.') }}
                            </x-ui.empty-state>
                        @endif
                    </x-ui.card>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
