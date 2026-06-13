@props(['title', 'categories', 'series', 'height' => 300])

@php
    $chartId = 'chart_' . \Illuminate\Support\Str::random(8);
@endphp

<x-ui.card :padding="false">
    <div class="p-6 border-b border-base-200 flex justify-between items-center">
        <h3 class="font-semibold text-base-content">{{ $title }}</h3>
        <span class="text-xs text-base-content/50">{{ __('30 Hari Terakhir') }}</span>
    </div>
    <div class="p-4">
        {{-- 
            Mitigasi Keamanan CSP (Anti Inline-Script):
            Seluruh data grafik disimpan secara aman sebagai atribut data-* HTML berkode JSON.
            Ini secara otomatis lolos dari pemfilteran XSS (HTML escaping) oleh Blade menggunakan {{ }}.
            Inisialisasi grafik dilakukan secara eksternal melalui resources/js/chart-loader.js.
        --}}
        <div id="{{ $chartId }}"
             class="apex-chart-container"
             data-series="{{ json_encode($series) }}"
             data-categories="{{ json_encode($categories) }}"
             data-height="{{ $height }}"
             data-locale="{{ config('app.locale') == 'id' ? 'id-ID' : 'en-US' }}"
             @style(['min-height' => $height . 'px'])>
        </div>
    </div>
</x-ui.card>
