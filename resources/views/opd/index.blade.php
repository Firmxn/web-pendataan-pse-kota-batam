@section('title', __('Manajemen'))
@section('section', __('Instansi / OPD'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 sm:px-0">
            <x-ui.heading>{{ __('Manajemen Instansi (OPD)') }}</x-ui.heading>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />

            <x-ui.card>
                <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 mb-4">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
                        {{-- Search Bar --}}
                        <x-form.search-input action="{{ route('opd.index') }}" value="{{ request('search') }}"
                            placeholder="{{ __('Cari Nama Instansi atau Email...') }}" />

                        {{-- Dropdown Filter Status --}}
                        <form action="{{ route('opd.index') }}" method="GET"
                            class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <div class="w-full sm:w-auto shrink-0">
                                <x-form.select name="status" size="sm" data-auto-submit>
                                    <option value="aktif"
                                        {{ request('status', 'aktif') === 'aktif' ? 'selected' : '' }}>
                                        {{ __('Aktif') }}</option>
                                    <option value="dihapus" {{ request('status') === 'dihapus' ? 'selected' : '' }}>
                                        {{ __('Dihapus') }}</option>
                                    <option value="semua" {{ request('status') === 'semua' ? 'selected' : '' }}>
                                        {{ __('Semua Status') }}</option>
                                </x-form.select>
                            </div>

                            @if (!request('search') && request('status') && request('status') !== 'aktif')
                                <a href="{{ route('opd.index') }}" class="btn btn-sm btn-ghost px-2 h-[30px]"
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

                    {{-- Admin Actions --}}
                    @if (auth()->user()->role->role_name === 'admin')
                        <div class="shrink-0">
                            <x-button.primary href="{{ route('opd.create') }}" size="sm" icon="plus">
                                {{ __('Tambah Instansi') }}
                            </x-button.primary>
                        </div>
                    @endif
                </div>

                @if ($opds->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <x-ui.table-sort field="name" :label="__('Nama Instansi')" />
                                <x-ui.table-sort field="type" :label="__('Tipe')" />
                                <x-ui.table-sort field="email" :label="__('Email Resmi')" />
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($opds as $opd)
                                <tr class="hover:bg-base-200">
                                    <td>{{ $opds->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="font-medium truncate max-w-[250px]" title="{{ $opd->name }}">
                                            {{ $opd->name }}
                                        </div>
                                    </td>
                                    <td>{{ $opd->type ?: '-' }}</td>
                                    <td>
                                        @if ($opd->email)
                                            <div class="tooltip" data-tip="{{ $opd->email }}">
                                                <span class="cursor-help">{{ Str::limit($opd->email, 25) }}</span>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($opd->trashed())
                                            <x-ui.badge variant="error" size="sm">{{ __('Dihapus') }}</x-ui.badge>
                                        @else
                                            <x-ui.badge variant="success"
                                                size="sm">{{ __('Aktif') }}</x-ui.badge>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            @if ($opd->trashed())
                                                @can('restore', $opd)
                                                    <form action="{{ route('opd.restore', $opd->id) }}" method="POST"
                                                        data-confirm="{{ __('dialogs.restore_opd') }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-button.accent size="sm" icon="restore" type="submit">
                                                            {{ __('Pulihkan') }}
                                                        </x-button.accent>
                                                    </form>
                                                @endcan
                                            @else
                                                <x-button.warning href="{{ route('opd.edit', $opd->id) }}"
                                                    size="sm" icon="pencil">
                                                    {{ __('Edit') }}
                                                </x-button.warning>

                                                @can('delete', $opd)
                                                    <form action="{{ route('opd.destroy', $opd->id) }}" method="POST"
                                                        data-confirm="{{ __('dialogs.deactivate_opd') }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-button.error size="sm" icon="trash" type="submit">
                                                            {{ __('Hapus') }}
                                                        </x-button.error>
                                                    </form>
                                                @endcan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    <div class="mt-4">
                        <div class="w-full sm:w-auto">
                            {{ $opds->links() }}
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                        @if (request('search') || request('status') !== 'aktif')
                            <p class="mb-4 text-center">
                                {{ __('Tidak ditemukan instansi dengan pencarian/filter yang diberikan.') }}
                            </p>
                            <x-button.ghost href="{{ route('opd.index') }}">
                                {{ __('Reset Filter') }}
                            </x-button.ghost>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                            <p class="text-lg font-medium">{{ __('Tidak ada data instansi.') }}</p>
                            <p class="text-sm">{{ __('Belum ada OPD yang terdaftar di dalam sistem.') }}</p>
                        @endif
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
