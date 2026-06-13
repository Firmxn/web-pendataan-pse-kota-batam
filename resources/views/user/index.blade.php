@section('title', __('Manajemen'))
@section('section', __('Pengguna'))

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4 sm:px-0">
            <x-ui.heading>{{ __('Manajemen Pengguna') }}</x-ui.heading>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />

            <x-ui.card>
                <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 mb-4">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
                        {{-- Search Bar --}}
                        <x-form.search-input action="{{ route('user.index') }}" value="{{ request('search') }}"
                            placeholder="{{ __('Cari Nama atau Email...') }}" />

                        {{-- Dropdown Filter Status --}}
                        <form action="{{ route('user.index') }}" method="GET"
                            class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <div class="w-full sm:w-auto shrink-0">
                                <x-form.select name="status" size="sm" data-auto-submit>
                                    <option value="aktif"
                                        {{ request('status', 'aktif') === 'aktif' ? 'selected' : '' }}>
                                        {{ __('Aktif & Terverifikasi') }}</option>
                                    <option value="dihapus" {{ request('status') === 'dihapus' ? 'selected' : '' }}>
                                        {{ __('Dihapus') }}</option>
                                    <option value="semua" {{ request('status') === 'semua' ? 'selected' : '' }}>
                                        {{ __('Semua Status') }}</option>
                                </x-form.select>
                            </div>

                            {{-- Tambahan Tombol Reset Khusus Jika Hanya Filter Status Yang Aktif (tanpa search) --}}
                            @if (!request('search') && request('status') && request('status') !== 'aktif')
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-ghost px-2 h-[30px]"
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
                            <x-button.primary href="{{ route('user.create') }}" size="sm" icon="user-plus">
                                {{ __('Registrasi') }}
                            </x-button.primary>
                        </div>
                    @endif
                </div>

                @if ($users->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <x-ui.table-sort field="name" :label="__('Nama Lengkap')" />
                                <x-ui.table-sort field="email" :label="__('Email')" />
                                <x-ui.table-sort field="name" :label="__('OPD')" />
                                <x-ui.table-sort field="role_name" :label="__('Peran')" />
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-base-200">
                                    <td>{{ $users->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="font-medium truncate max-w-[200px]" title="{{ $user->name }}">
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $user->email }}">
                                            <span class="cursor-help">{{ Str::limit($user->email, 25) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $user->opd->name ?? '-' }}">
                                            <span class="cursor-help">{{ Str::limit($user->opd->name ?? '-', 25) }}

                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ __(ucfirst(str_replace('_', ' ', $user->role->role_name ?? '-'))) }}
                                    </td>
                                    <td>
                                        @if ($user->trashed())
                                            <x-ui.badge variant="error" size="sm">{{ __('Dihapus') }}</x-ui.badge>
                                        @else
                                            <x-ui.badge variant="success"
                                                size="sm">{{ __('Aktif') }}</x-ui.badge>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            {{-- Tombol Detail --}}
                                            <x-button.info href="{{ route('user.show', $user->uuid) }}" size="sm"
                                                icon="eye">
                                                {{ __('Detail') }}
                                            </x-button.info>

                                            @can('update', $user)
                                                {{-- Tombol Edit --}}
                                                <x-button.warning href="{{ route('user.edit', $user->uuid) }}"
                                                    size="sm" icon="pencil">
                                                    {{ __('Edit') }}
                                                </x-button.warning>
                                            @endcan

                                            @if ($user->trashed())
                                                {{-- Tombol Restore (hanya muncul jika user ini sudah di-soft-delete) --}}
                                                @can('restore', $user)
                                                    <form action="{{ route('user.restore', $user->uuid) }}" method="POST"
                                                        data-confirm="{{ __('dialogs.restore_user') }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-button.accent size="sm" icon="restore" type="submit">
                                                            {{ __('Pulihkan') }}
                                                        </x-button.accent>
                                                    </form>
                                                @endcan
                                            @else
                                                {{-- Tombol Deactivate/Delete (hanya muncul jika akun masih aktif) --}}
                                                @can('delete', $user)
                                                    <form action="{{ route('user.destroy', $user->uuid) }}" method="POST"
                                                        data-confirm="{{ __('dialogs.deactivate_user') }}">
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
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                            @if (request('search') || request('status') !== 'aktif')
                                <p class="mb-4 text-center">
                                    {{ __('Tidak ditemukan pengguna dengan kriteria yang diberikan.') }}
                                </p>
                                <x-button.ghost href="{{ route('user.index') }}">
                                    {{ __('Reset Filter') }}
                                </x-button.ghost>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <p class="text-lg font-medium">{{ __('Tidak ada pengguna.') }}</p>
                            @endif
                        </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
