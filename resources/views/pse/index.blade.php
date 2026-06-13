@section('title', __('Manajemen'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                {{ __('Manajemen PSE') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />

            <x-ui.card>
                <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 mb-4">
                    <div class="flex-1 max-w-2xl flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <x-form.search-input action="{{ route('pse.index') }}" value="{{ request('search') }}"
                            placeholder="{{ __('Cari Nama Sistem...') }}" />

                        {{-- Dropdown Filter Status --}}
                        <form action="{{ route('pse.index') }}" method="GET"
                            class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if (request('per_page'))
                                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                            @endif

                            <div class="w-full sm:w-auto shrink-0">
                                <x-form.select name="status" class="select-sm w-full h-[30px]"
                                    data-auto-submit>
                                    <option value="semua"
                                        {{ request('status', 'semua') === 'semua' ? 'selected' : '' }}>
                                        {{ __('Semua Status') }}</option>
                                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                                        {{ __('Draft') }}</option>
                                    <option value="pending_1"
                                        {{ request('status') === 'pending_1' ? 'selected' : '' }}>
                                        {{ __('Pending Verifikasi 1') }}</option>
                                    <option value="pending_2"
                                        {{ request('status') === 'pending_2' ? 'selected' : '' }}>
                                        {{ __('Pending Verifikasi 2') }}</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                                        {{ __('Disetujui') }}</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>
                                        {{ __('Ditolak') }}</option>
                                </x-form.select>
                            </div>

                            {{-- Tombol Reset --}}
                            @if (request('search') || (request('status') && request('status') !== 'semua'))
                                <a href="{{ route('pse.index') }}" class="btn btn-sm btn-ghost px-2 h-[30px]"
                                    title="{{ __('Reset Filter') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="shrink-0 flex items-center gap-3 text-right">
                        {{-- Tombol Tambah dengan Tooltip --}}
                        <div class="tooltip tooltip-left w-full" data-tip="Draft: {{ $draftCount }}/2">
                            <x-button.primary href="{{ route('pse.create') }}" size="sm"
                                class="w-full sm:w-auto justify-center">
                                {{ __('Tambah Pendataan') }}
                            </x-button.primary>
                        </div>
                    </div>
                </div>

                @if ($pses->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th class="px-4 py-3">{{ __('No') }}</th>
                                <x-ui.table-sort field="system_name" :label="__('Nama Sistem')" />
                                <x-ui.table-sort field="sector" :label="__('Sektor')" />
                                <th class="px-4 py-3">{{ __('OPD') }}</th>
                                <th class="px-4 py-3">{{ __('Status') }}</th>
                                <th class="px-4 py-3">{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($pses as $pse)
                                <tr class="hover:bg-base-200">
                                    <td>{{ $pses->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $pse->system_name }}">
                                            <span
                                                class="cursor-help font-medium">{{ Str::limit($pse->system_name, 24) }}</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap">{{ $pse->sector_label }}</td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $pse->opd->name ?? '-' }}">
                                            <span
                                                class="cursor-help">{{ Str::limit($pse->opd->name ?? '-', 25) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <x-display.status-badge :status="$pse->status" />
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <x-button.info href="{{ route('pse.show', $pse) }}" size="sm"
                                                icon="eye">
                                                {{ __('Detail') }}
                                            </x-button.info>
                                            @can('update', $pse)
                                                @if (in_array($pse->status, ['draft', 'rejected']))
                                                    <form action="{{ route('pse.submit', $pse) }}" method="POST"
                                                        data-confirm="{{ __('dialogs.submit_pse') }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-button.success size="sm" icon="assign">
                                                            {{ $pse->status === 'rejected' ? __('Ajukan Kembali') : __('Ajukan') }}
                                                        </x-button.success>
                                                    </form>
                                                @endif
                                                <x-button.warning href="{{ route('pse.edit', $pse) }}" size="sm"
                                                    icon="pencil">
                                                    {{ __('Edit') }}
                                                </x-button.warning>
                                            @endcan
                                            @can('delete', $pse)
                                                <form action="{{ route('pse.destroy', $pse) }}" method="POST"
                                                    data-confirm="{{ __('dialogs.delete_pse') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button.error size="sm" icon="trash">
                                                        {{ __('Hapus') }}
                                                    </x-button.error>
                                                </form>
                                            @endcan
                                        </div>
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
                            <p class="mb-4">{{ __('Tidak ditemukan data PSE dengan kata kunci') }}
                                "<strong>{{ request('search') }}</strong>".
                            </p>
                            <x-button.ghost href="{{ route('pse.index') }}">
                                {{ __('Reset Pencarian') }}
                            </x-button.ghost>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke-width="1.5" stroke="currentColor"
                                class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S12 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S12 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                            <p class="text-lg font-medium">{{ __('Belum ada pendataan PSE.') }}</p>
                            <p class="text-sm">{{ __('Klik tombol "Tambah Pendataan" untuk membuat yang baru.') }}</p>
                        @endif
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
