@section('title', __('Manajemen'))
@section('section', __('Subdomain'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Manajemen Subdomain') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <x-ui.alert-session />

            <x-ui.card>
                <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 mb-4">
                    <div class="flex-1 max-w-2xl flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <x-form.search-input action="{{ route('subdomain.index') }}"
                            value="{{ request('search') }}"
                            placeholder="{{ __('Cari Nama Subdomain...') }}" />

                        {{-- Dropdown Filter Status --}}
                        <form action="{{ route('subdomain.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('per_page'))
                                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                            @endif
                            
                            <div class="w-full sm:w-auto shrink-0">
                                <x-form.select name="status" class="select-sm w-full h-[30px]" data-auto-submit>
                                    <option value="semua" {{ request('status', 'semua') === 'semua' ? 'selected' : '' }}>{{ __('Semua Status') }}</option>
                                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                    <option value="pending_1" {{ request('status') === 'pending_1' ? 'selected' : '' }}>{{ __('Pending Verifikasi 1') }}</option>
                                    <option value="pending_2" {{ request('status') === 'pending_2' ? 'selected' : '' }}>{{ __('Pending Verifikasi 2') }}</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>{{ __('Disetujui') }}</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ __('Ditolak') }}</option>
                                </x-form.select>
                            </div>

                            {{-- Tombol Reset --}}
                            @if (request('search') || (request('status') && request('status') !== 'semua'))
                                <a href="{{ route('subdomain.index') }}" class="btn btn-sm btn-ghost px-2 h-[30px]" title="{{ __('Reset Filter') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </form>
                    </div>
                    <div class="shrink-0 flex items-center gap-3">
                        {{-- Tombol Tambah --}}
                        <x-button.primary href="{{ route('subdomain.create') }}" size="sm" class="w-full sm:w-auto justify-center">
                            {{ __('Tambah Pengajuan') }}
                        </x-button.primary>
                    </div>
                </div>

                @if ($subdomains->isNotEmpty())
                    <x-ui.table>
                        <x-ui.table-head>
                            <tr>
                                <th class="px-4 py-3">{{ __('No') }}</th>
                                <x-ui.table-sort field="system_name" :label="__('Nama Sistem')" />
                                <x-ui.table-sort field="request_type" :label="__('Tipe Pengajuan')" />
                                <x-ui.table-sort field="subdomain_name" :label="__('Subdomain')" />
                                <th class="px-4 py-3">{{ __('Status') }}</th>
                                <th class="px-4 py-3">{{ __('Aksi') }}</th>
                            </tr>
                        </x-ui.table-head>
                        <tbody>
                            @foreach ($subdomains as $request)
                                <tr class="hover:bg-base-200">
                                    <td>{{ $subdomains->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $request->pse->system_name }}">
                                            <span
                                                class="cursor-help">{{ Str::limit($request->pse->system_name, 25) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <x-display.request-type-badge :type="$request->request_type" />
                                    </td>
                                    <td>{{ $request->subdomain_name }}</td>
                                    <td>
                                        <x-display.status-badge :status="$request->status" class="min-w-24 badge-soft" />
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <x-button.info href="{{ route('subdomain.show', $request) }}"
                                                size="sm" icon="eye">
                                                {{ __('Detail') }}
                                            </x-button.info>
                                            @can('update', $request)
                                                @if (in_array($request->status, ['draft', 'rejected']))
                                                    <form action="{{ route('subdomain.submit', $request) }}" method="POST"
                                                        data-confirm="{{ in_array($request->pse->status, ['draft', 'rejected']) ? __('dialogs.submit_single_flow') : __('dialogs.submit_subdomain') }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-button.success size="sm" icon="assign">
                                                            {{ $request->status === 'rejected' ? __('Ajukan Kembali') : __('Ajukan') }}
                                                        </x-button.success>
                                                    </form>
                                                @endif
                                                <x-button.warning href="{{ route('subdomain.edit', $request) }}"
                                                    size="sm" icon="pencil">
                                                    {{ __('Edit') }}
                                                </x-button.warning>
                                            @endcan
                                            @can('delete', $request)
                                                @if(!in_array($request->pse->status, ['draft', 'rejected']))
                                                    <form action="{{ route('subdomain.destroy', $request) }}" method="POST"
                                                        data-confirm="{{ __('dialogs.delete_request') }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-button.error size="sm" icon="trash">
                                                            {{ __('Hapus') }}
                                                        </x-button.error>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table>

                    <div class="mt-4">
                        {{ $subdomains->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-base-content/50">
                        @if (request('search'))
                            <p class="mb-4">{{ __('Tidak ditemukan data pengajuan subdomain dengan kata kunci') }}
                                "<strong>{{ request('search') }}</strong>".</p>
                            <x-button.ghost href="{{ route('subdomain.index') }}">
                                {{ __('Reset Pencarian') }}
                            </x-button.ghost>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-4 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                            <p class="text-lg font-medium">{{ __('Belum ada data pengajuan subdomain.') }}</p>
                            <p class="text-sm">{{ __('Klik tombol "Tambah Pengajuan" untuk membuat yang baru.') }}</p>
                        @endif
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
