@if ($paginator->total() > 0)
    {{-- Container Navigasi Pagination Utama --}}
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">

        {{-- Tampilan Mobile (Tombol Kustom Besar) --}}
        {{-- Logic: Pada layar kecil (sm:hidden), tampilkan tombol Previous/Next yang lebih besar dan mudah ditekan --}}
        <div class="flex justify-between items-center w-full sm:hidden gap-2">

            {{-- Tombol 'Sebelumnya' di Mobile --}}
            @if ($paginator->onFirstPage())
                {{-- State: Disabled (Jika di halaman pertama) --}}
                <div
                    class="flex items-center justify-between flex-1 max-w-[120px] px-3 py-2 bg-base-200/50 rounded-lg opacity-50 cursor-not-allowed">
                    <svg class="w-4 h-4 text-base-content/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[9px] font-bold uppercase tracking-wider text-base-content/50">{{ __('Sebelumnya') }}</span>
                        <span class="text-[10px] font-medium text-base-content/50">-</span>
                    </div>
                </div>
            @else
                {{-- State: Active (Link ke halaman sebelumnya) --}}
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="flex items-center justify-between flex-1 max-w-[120px] px-3 py-2 text-neutral-content bg-neutral rounded-xl group hover:bg-slate-700 transition-all">
                    <svg class="w-4 h-4 text-neutral-content group-hover:text-neutral-content transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[9px] font-bold uppercase tracking-wider text-neutral-content group-hover:text-slate-300 transition-colors">{{ __('Sebelumnya') }}</span>
                        <span class="text-xs font-bold text-neutral-content">{{ __('Hal') }}
                            {{ $paginator->currentPage() - 1 }}</span>
                    </div>
                </a>
            @endif

            {{-- Tombol 'Selanjutnya' di Mobile --}}
            @if ($paginator->hasMorePages())
                {{-- State: Active (Link ke halaman berikutnya) --}}
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="flex items-center justify-between flex-1 max-w-[120px] px-3 py-2 text-neutral-content bg-neutral rounded-xl group hover:bg-slate-700 transition-all">
                    <div class="flex flex-col items-start">
                        <span
                            class="text-[9px] font-bold uppercase tracking-wider text-neutral-content group-hover:text-slate-300 transition-colors">{{ __('Selanjutnya') }}</span>
                        <span class="text-xs font-bold text-neutral-content">{{ __('Hal') }}
                            {{ $paginator->currentPage() + 1 }}</span>
                    </div>
                    <svg class="w-4 h-4 text-neutral-content group-hover:text-neutral-content transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                {{-- State: Disabled (Jika di halaman terakhir) --}}
                <div
                    class="flex items-center justify-between flex-1 max-w-[120px] px-3 py-2 bg-base-200/50 rounded-lg opacity-50 cursor-not-allowed">
                    <div class="flex flex-col items-start">
                        <span
                            class="text-[9px] font-bold uppercase tracking-wider text-base-content/50">{{ __('Selanjutnya') }}</span>
                        <span class="text-[10px] font-medium text-base-content/50">-</span>
                    </div>
                    <svg class="w-4 h-4 text-base-content/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Tampilan Desktop (Info Lengkap & Link Angka) --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            {{-- Informasi Bagian Kiri (Per Page Selector & Teks Info) --}}
            <div class="flex items-center gap-4">
                <x-form.per-page-selector />
                <p class="text-sm text-base-content/70 whitespace-nowrap">
                    <span>{{ $paginator->firstItem() ?? 0 }}</span>
                    -
                    <span>{{ $paginator->lastItem() ?? 0 }}</span>
                    {{ __('dari') }}
                    <span>{{ $paginator->total() }}</span>
                </p>
            </div>

            {{-- Grup Link Halaman --}}
            <div class="join border border-base-200 rounded-xl bg-base-100 overflow-hidden">
                {{-- Link Halaman Sebelumnya (Panah Kiri) --}}
                @if ($paginator->onFirstPage())
                    <button class="join-item btn btn-sm btn-ghost border-none text-base-content/50" disabled
                        aria-hidden="true">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="join-item btn btn-sm btn-ghost border-none hover:bg-base-200 text-base-content"
                        rel="prev" aria-label="{{ __('pagination.previous') }}">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                {{-- Elemen Pagination (Angka Halaman) --}}
                @foreach ($elements as $element)
                    {{-- Separator "Three Dots" (...) --}}
                    @if (is_string($element))
                        <button class="join-item btn btn-sm btn-disabled">{{ $element }}</button>
                    @endif

                    {{-- Array Link Halaman --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                {{-- Halaman Aktif (Tombol Primary) --}}
                                <button
                                    class="join-item btn btn-sm btn-primary border-none rounded-none"
                                    aria-current="page">{{ $page }}</button>
                            @else
                                {{-- Halaman Tidak Aktif (Tombol Ghost biasa) --}}
                                <a href="{{ $url }}"
                                    class="join-item btn btn-sm btn-ghost border-none">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Link Halaman Selanjutnya (Panah Kanan) --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="join-item btn btn-sm btn-ghost border-none"
                        rel="next" aria-label="{{ __('pagination.next') }}">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <button class="join-item btn btn-sm btn-ghost border-none text-base-content/50" disabled aria-hidden="true">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </nav>
@endif
