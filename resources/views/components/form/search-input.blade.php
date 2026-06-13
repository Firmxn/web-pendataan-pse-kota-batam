@props([
    'action' => '#',
    'method' => 'GET',
    'placeholder' => __('Search...'),
    'value' => '',
    'name' => 'search',
])

<form action="{{ $action }}" method="{{ $method }}"
    {{ $attributes->merge(['class' => 'flex items-center gap-2 w-full flex-1 max-w-xs group']) }}>
    {{ $slot }}
    <div class="relative flex items-center grow">
        {{-- Icon Search --}}
        <svg class="absolute left-3 w-4 h-4 text-base-content/50 group-focus-within:text-primary z-10"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>

        {{-- Input Field - Menggunakan kustom class berbarengan dengan DaisyUI --}}
        <input type="search" name="{{ $name }}" value="{{ $value }}"
                    {{-- class="input input-bordered w-full pl-9 pr-4 py-1.5 text-xs h-auto min-h-0 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 placeholder:text-base-content/50" --}}
            class="input w-full pl-9 pr-4 py-1.5 text-xs h-auto min-h-0 bg-base-100 border border-base-200 rounded-xl hover:border-base-300 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 placeholder:text-base-content/50 transition-all duration-200"
            placeholder="{{ $placeholder }}" />
    </div>

    {{-- Tombol Reset (Muncul jika ada value) --}}
    @if ($value)
        <a href="{{ $action }}" class="btn btn-sm btn-ghost px-2 h-[30px]" title="{{ __('Reset Pencarian') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    @endif
</form>
