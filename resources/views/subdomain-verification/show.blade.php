@php
    $isFinal = request()->routeIs('subdomain-verification2.*');
    $routePrefix = $isFinal ? 'subdomain-verification2' : 'subdomain-verification';
@endphp

@section('title', $isFinal ? __('Verifikasi Subdomain - Final') : __('Verifikasi Subdomain'))
@section('section', __('Subdomain'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <x-ui.heading level="2">
                {{ $isFinal ? __('Verifikasi Subdomain - Final') : __('Verifikasi Subdomain') }}
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
                                        <span>{{ __('Sistem Elektronik') }}</span>
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
                                        <th>{{ __('Subdomain') }}</th>
                                        <th>{{ __('URL Akses') }}</th>
                                        <th class="text-center">{{ __('Status') }}</th>
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
                                                    <span
                                                        class="font-bold text-base-content {{ $sub->id === $subdomain->id ? 'text-primary' : '' }}">
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

                    {{-- FORMULIR VERIFIKASI --}}
                    @if (($isFinal && $subdomain->status === 'pending_2') || (!$isFinal && $subdomain->status === 'pending_1'))
                        <x-ui.card icon="check-square" :title="$isFinal ? __('Panel Verifikasi Tahap 2 (Final)') : __('Panel Verifikasi Tahap 1')">
                            <div class="space-y-8">
                                {{-- Section Setujui --}}
                                <div class="p-6 rounded-3xl bg-success/5 border border-success/10 space-y-4">
                                    <div class="flex items-center gap-3 text-success">
                                        <h4 class="font-bold text-lg">{{ __('Setujui Subdomain') }}</h4>
                                    </div>
                                    @if (!$isFinal)
                                        <p class="text-sm text-base-content/60">
                                            {{ __('Gunakan opsi ini jika data sudah valid dan layak untuk diteruskan ke Tahap 2.') }}
                                        </p>
                                    @endif
                                    <form method="POST" action="{{ route($routePrefix . '.approve', $subdomain) }}" data-confirm="{{ $isFinal ? __('dialogs.approve_subdomain_v2') : __('dialogs.approve_subdomain_v1') }}"
                                        class="space-y-4">
                                        @csrf
                                        @method('PATCH')
                                        <x-form.fieldset :label="__('Catatan Persetujuan (Opsional)')">
                                            <x-form.textarea name="notes" rows="2"
                                                placeholder="{{ __('Opsional...') }}"></x-form.textarea>
                                            <x-form.input-error :messages="$errors->get('notes')" />
                                        </x-form.fieldset>
                                        <div class="flex justify-end">
                                            <x-button.success size="sm" icon="check"
                                                type="submit">
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
                                        <h4 class="font-bold text-lg">{{ __('Tolak Subdomain') }}</h4>
                                    </div>
                                    @if (!$isFinal)
                                        <p class="text-sm text-base-content/60">
                                            {{ __('Gunakan opsi ini jika terdapat data yang salah atau berkas yang tidak valid.') }}
                                        </p>
                                    @endif
                                    <form method="POST" action="{{ route($routePrefix . '.reject', $subdomain) }}" data-confirm="{{ __('dialogs.reject_subdomain') }}"
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
                                            <x-button.error size="sm" icon="x"
                                                type="submit">
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
                        @if ($subdomain->status === 'pending_2')
                            <x-ui.alert variant="info">
                                {{ __('messages.subdomain.verify2_info_pending') }}
                            </x-ui.alert>
                        @elseif ($subdomain->status === 'approved')
                            <x-ui.alert variant="primary">
                                {{ __('messages.subdomain.verify2_info_approved') }}
                            </x-ui.alert>
                        @endif
                    @endif

                    {{-- ALERT SINGLE FLOW --}}
                    @if ($subdomain->pse->storage_location === 'aplikasi' && in_array($subdomain->pse->status, ['pending_1', 'pending_2']))
                        <x-ui.alert variant="warning">
                            <div class="space-y-1">
                                <p class="font-bold text-sm">{{ __('messages.single_flow.title') }}</p>
                                <p class="text-xs leading-relaxed opacity-90">
                                    {{ __('messages.single_flow.info_subdomain') }}
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
                                <x-display.text-value>{{ $subdomain->pse->opd->name ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="building" light>{{ __('Tipe') }}</x-display.text-label>
                                <x-display.text-value>{{ $subdomain->pse->opd->type ?? '-' }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="building" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $subdomain->pse->opd->email ?? '-' }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $subdomain->pse->opd->email ?? '-' }}
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
                                <x-display.text-value>{{ $subdomain->user->name }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>{{ __('Telepon') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $subdomain->user->phone }}" target="_blank"
                                        class="link link-primary link-hover">
                                        {{ format_phone($subdomain->user->phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $subdomain->user->email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $subdomain->user->email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                        <div class="pt-2">
                            <x-button.ghost href="{{ route('user.show', $subdomain->user) }}" size="sm"
                                class="w-full text-[10px] uppercase tracking-wider" icon="user">
                                {{ __('Lihat Profil Lengkap') }}
                            </x-button.ghost>
                        </div>
                    </x-ui.card>

                    {{-- INFORMASI PENANGGUNG JAWAB --}}
                    <x-ui.card icon="user" :title="__('Informasi Penanggung Jawab')">
                        <div class="space-y-6">
                            <div>
                                <x-display.text-label icon="user" light>{{ __('Nama PIC') }}</x-display.text-label>
                                <x-display.text-value>{{ $subdomain->pse->pic_name }}</x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="phone" light>{{ __('Telepon') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="https://wa.me/{{ $subdomain->pse->pic_phone }}" target="_blank"
                                        class="link link-hover link-primary">
                                        {{ format_phone($subdomain->pse->pic_phone) }}
                                    </a>
                                </x-display.text-value>
                            </div>
                            <div>
                                <x-display.text-label icon="mail" light>{{ __('Email') }}</x-display.text-label>
                                <x-display.text-value>
                                    <a href="mailto:{{ $subdomain->pse->pic_email }}"
                                        class="link link-hover link-primary truncate inline-block max-w-full lowercase">
                                        {{ $subdomain->pse->pic_email }}
                                    </a>
                                </x-display.text-value>
                            </div>
                        </div>
                    </x-ui.card>

                    {{-- DOKUMEN --}}
                    @php
                        $subdomainDocuments = $subdomain->pse->subdomainRequests
                            ->pluck('document')
                            ->filter()
                            ->unique('file_path');
                    @endphp
                    <x-ui.card icon="file-text" :title="__('Surat Permohonan')">
                        <div class="space-y-4">
                            @forelse ($subdomainDocuments as $doc)
                                <x-display.document-card :document="$doc" :title="__('Surat Permohonan Subdomain')" icon="globe"
                                    color="primary" />
                            @empty
                                <x-ui.empty-state icon="file-x" size="12">
                                    {{ __('Berkas surat tidak tersedia.') }}
                                </x-ui.empty-state>
                            @endforelse
                        </div>
                    </x-ui.card>

                    {{-- RIWAYAT VERIFIKASI --}}
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
                                                        "{!! nl2br(e($history->notes)) !!}"
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
