@php
    $isFinal = request()->routeIs('hosting-verification2.*');
    $routePrefix = $isFinal ? 'hosting-verification2' : 'hosting-verification';
@endphp

@section('title', $isFinal ? __('Verifikasi Hosting - Final') : __('Verifikasi Hosting'))
@section('section', __('Hosting'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <x-ui.heading level="2">
                {{ $isFinal ? __('Verifikasi Hosting - Final') : __('Verifikasi Hosting') }}
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

                {{-- KOLOM UTAMA --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- HERO CARD: IDENTITAS UTAMA --}}
                    <div
                        class="relative overflow-hidden bg-linear-to-br from-primary/10 via-base-100 to-base-100 rounded-4xl border border-primary/10 shadow-xl group transition-all duration-300">
                        <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                            <x-icons.icon name="server" size="32" class="text-primary" />
                        </div>
                        <div class="p-8 relative">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <div
                                        class="flex items-center gap-2 text-primary text-xs font-bold tracking-widest uppercase mb-1">
                                        <x-icons.icon name="cpu" size="4" />
                                        <span>{{ __('Sistem Elektronik') }}</span>
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

                    {{-- SPESIFIKASI SERVER --}}
                    <x-ui.card icon="activity" :title="__('Spesifikasi Sumber Daya')">
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                <x-display.text-label light
                                    class="text-[10px] mb-1">{{ __('CPU') }}</x-display.text-label>
                                <p class="font-bold text-lg text-base-content">
                                    {{ $hosting->cpu_cores }} Cores
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                <x-display.text-label light
                                    class="text-[10px] mb-1">{{ __('RAM') }}</x-display.text-label>
                                <p class="font-bold text-lg text-base-content">
                                    {{ $hosting->ram_capacity }} GB
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                <x-display.text-label light
                                    class="text-[10px] mb-1">{{ __('Storage') }}</x-display.text-label>
                                <p class="font-bold text-lg text-base-content">
                                    {{ $hosting->storage_capacity }} GB
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-base-200/50 border border-base-300/30">
                                <x-display.text-label light
                                    class="text-[10px] mb-1">{{ __('Bandwidth') }}</x-display.text-label>
                                <p class="font-bold text-lg text-base-content">
                                    {{ $hosting->bandwidth_capacity >= 1000 ? $hosting->bandwidth_capacity / 1000 : $hosting->bandwidth_capacity }}
                                    <span
                                        class="text-xs">{{ $hosting->bandwidth_capacity >= 1000 ? 'TB' : 'GB' }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Baris 2: Detail Tipe (2 Kolom) --}}
                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-display.text-label icon="cpu" light>
                                    {{ __('Tipe Layanan') }}
                                </x-display.text-label>
                                <x-display.text-value>{{ ucfirst($hosting->hosting_type) }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="send" light>
                                    {{ __('Tipe Pengajuan') }}
                                </x-display.text-label>
                                <x-display.request-type-badge :type="$hosting->request_type" />
                            </div>
                        </div>

                        {{-- Baris 3: Catatan (1 Kolom Penuh) --}}
                        @if ($hosting->notes)
                            <div class="mt-8">
                                <x-display.text-label icon="sticky-note" light>
                                    {{ __('Catatan Kebutuhan Khusus') }}
                                </x-display.text-label>
                                <x-display.text-value class="font-normal text-justify leading-relaxed">
                                    {!! nl2br(e($hosting->notes)) !!}
                                </x-display.text-value>
                            </div>
                        @endif
                    </x-ui.card>

                    {{-- FORMULIR VERIFIKASI --}}
                    @if (($isFinal && $hosting->status === 'pending_2') || (!$isFinal && $hosting->status === 'pending_1'))
                        <x-ui.card icon="check-square" :title="$isFinal ? __('Panel Verifikasi Tahap 2 (Final)') : __('Panel Verifikasi Tahap 1')">
                            <div class="space-y-8">
                                {{-- Section Setujui --}}
                                <div class="p-6 rounded-3xl bg-success/5 border border-success/10 space-y-4">
                                    <div class="flex items-center gap-3 text-success">
                                        <h4 class="font-bold text-lg">{{ __('Setujui Hosting') }}</h4>
                                    </div>
                                    @if (!$isFinal)
                                        <p class="text-sm text-base-content/60">
                                            {{ __('Gunakan opsi ini jika data sudah valid dan layak untuk diteruskan ke Tahap 2.') }}
                                        </p>
                                    @endif
                                    <form method="POST" action="{{ route($routePrefix . '.approve', $hosting) }}" data-confirm="{{ $isFinal ? __('dialogs.approve_hosting_v2') : __('dialogs.approve_hosting_v1') }}"
                                        class="space-y-4">
                                        @csrf
                                        @method('PATCH')
                                        <x-form.fieldset :label="__('Catatan Persetujuan (Opsional)')">
                                            <x-form.textarea name="notes" rows="2"
                                                placeholder="{{ __('Opsional...') }}"></x-form.textarea>
                                            <x-form.input-error :messages="$errors->get('notes')" />
                                        </x-form.fieldset>
                                        <div class="flex justify-end">
                                            <x-button.success size="sm" icon="check" type="submit">
                                                {{ $isFinal ? __('Setujui & Selesaikan') : __('Setujui & Teruskan') }}
                                            </x-button.success>
                                        </div>
                                    </form>
                                </div>

                                <div class="divider text-[10px] font-bold opacity-30">{{ __('ATAU') }}</div>

                                {{-- Section Tolak --}}
                                <div class="p-6 rounded-3xl bg-error/5 border border-error/10 space-y-4 text-error">
                                    <div class="flex items-center gap-3">
                                        <x-icons.icon name="x-circle" size="6" />
                                        <h4 class="font-bold text-lg">{{ __('Tolak Hosting') }}</h4>
                                    </div>
                                    @if (!$isFinal)
                                        <p class="text-sm text-base-content/60">
                                            {{ __('Gunakan opsi ini jika terdapat data yang salah atau berkas yang tidak valid.') }}
                                        </p>
                                    @endif
                                    <form method="POST" action="{{ route($routePrefix . '.reject', $hosting) }}" data-confirm="{{ __('dialogs.reject_hosting') }}"
                                        class="space-y-4 text-base-content">
                                        @csrf
                                        @method('PATCH')
                                        <x-form.fieldset :label="__('Alasan Penolakan (Wajib)')">
                                            <x-form.textarea name="notes" rows="3" required
                                                placeholder="{{ __('Wajib diisi...') }}"></x-form.textarea>
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

                {{-- KOLOM SAMPING --}}
                <div class="space-y-6">

                    {{-- ALERT STATUS --}}
                    @if ($isFinal)
                        @if ($hosting->status === 'pending_2')
                            <x-ui.alert variant="info">
                                {{ __('messages.hosting.verify2_info_pending') }}
                            </x-ui.alert>
                        @elseif ($hosting->status === 'approved')
                            <x-ui.alert variant="primary">
                                {{ __('messages.hosting.verify2_info_approved') }}
                            </x-ui.alert>
                        @endif
                    @endif

                    {{-- ALERT SINGLE FLOW --}}
                    @if ($hosting->pse->storage_location === 'aplikasi' && in_array($hosting->pse->status, ['pending_1', 'pending_2']))
                        <x-ui.alert variant="warning">
                            <div class="space-y-1">
                                <p class="font-bold text-sm">{{ __('messages.single_flow.title') }}</p>
                                <p class="text-xs leading-relaxed opacity-90">
                                    {{ __('messages.single_flow.info_hosting') }}
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
                                <x-display.text-label icon="building" light>{{ __('Nama OPD') }}</x-display.text-label>
                                <x-display.text-value>{{ $hosting->pse->opd->name ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="building" light>{{ __('Tipe') }}</x-display.text-label>
                                <x-display.text-value>{{ $hosting->pse->opd->type ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="building" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $hosting->pse->opd->email ?? '-' }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $hosting->pse->opd->email ?? '-' }}
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
                                <x-display.text-value>{{ $hosting->user->name }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>{{ __('Telepon') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $hosting->user->phone }}" target="_blank"
                                        class="link link-primary link-hover">
                                        {{ format_phone($hosting->user->phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $hosting->user->email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $hosting->user->email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div class="pt-2">
                                <x-button.ghost href="{{ route('user.show', $hosting->user) }}" size="sm"
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
                                <x-display.text-value>{{ $hosting->pse->pic_name }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>{{ __('Telepon') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $hosting->pse->pic_phone }}" target="_blank"
                                        class="link link-hover link-primary">
                                        {{ format_phone($hosting->pse->pic_phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $hosting->pse->pic_email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $hosting->pse->pic_email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- DOKUMEN --}}
                    @php
                        $subdomainDocs = $hosting->pse->subdomainRequests
                            ->pluck('document')
                            ->filter()
                            ->unique('file_path');
                        $anySdoc = $subdomainDocs->isNotEmpty();
                    @endphp
                    <x-ui.card icon="file-text" :title="__('Surat Permohonan')">
                        <div class="space-y-4">
                            @if ($hosting->document)
                                <x-display.document-card :document="$hosting->document" :title="__('Surat Permohonan Hosting')" icon="cpu"
                                    color="accent" />
                            @endif

                            @if ($hosting->pse->storage_location === 'aplikasi' && $anySdoc)
                                @foreach ($subdomainDocs as $doc)
                                    <x-display.document-card :document="$doc" :title="__('Surat Permohonan Subdomain (Paket)')" icon="globe"
                                        color="primary" />
                                @endforeach
                            @endif

                            @if (!$hosting->document && (!$anySdoc || $hosting->pse->storage_location !== 'aplikasi'))
                                <x-ui.empty-state icon="file-x" size="12">
                                    {{ __('Berkas surat tidak tersedia.') }}
                                </x-ui.empty-state>
                            @endif
                        </div>
                    </x-ui.card>

                    <x-ui.card icon="history" :title="__('Riwayat Verifikasi')">
                        @if ($hosting->verificationHistories && $hosting->verificationHistories->isNotEmpty())
                            <div
                                class="relative space-y-6 before:absolute before:left-4 before:top-2 before:bottom-0 before:w-0.5 before:bg-base-300/50">
                                @foreach ($hosting->verificationHistories->sortByDesc('created_at') as $history)
                                    <div class="relative pl-10 group">
                                        <div class="absolute left-0 top-1.5 w-8 h-8 flex items-center justify-center">
                                            <div
                                                class="w-3 h-3 rounded-full border-2 border-base-100 {{ status_bg_color($history->status) }} ring-4 ring-base-200 shadow-sm">
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
                                                {{ $history->user->name }}</p>
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
