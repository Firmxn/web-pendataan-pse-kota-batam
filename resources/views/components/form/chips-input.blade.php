@props(['name', 'value' => [], 'placeholder' => null, 'id' => null, 'hasError' => false])

@php
    $id = $id ?? 'chips_'.str_replace(['[]', '[', ']'], ['_', '_', ''], $name).'_'.uniqid();
    $initialValues = is_array($value) ? $value : (is_string($value) ? json_decode($value, true) ?? [] : []);
    $defaultPlaceholder = $placeholder ?? __('Ketik lalu tekan Enter atau Spasi...');
    
    // Sinkronisasi class dengan x-form.text-input
    $baseClasses = 'input w-full bg-base-100 rounded-xl transition-all duration-200 flex flex-wrap items-center gap-2 h-auto min-h-12 py-1 px-3 cursor-text hover:border-base-300';
    
    if ($hasError) {
        $visualClasses = $baseClasses . ' border border-error focus-within:ring-1 focus-within:ring-error/20 outline-none';
    } else {
        $visualClasses = $baseClasses . ' border border-base-200 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 focus-within:outline-none';
    }
@endphp

<div id="container_{{ $id }}" 
     class="chips-input-container w-full"
     data-id="{{ $id }}"
     data-name="{{ $name }}"
     data-placeholder="{{ $defaultPlaceholder }}"
     data-initial="{{ json_encode($initialValues) }}"
     data-utama-label="{{ __('UTAMA') }}">
    <label id="visual_{{ $id }}"
        class="{{ $visualClasses }} cursor-text"
        for="input_{{ $id }}">
        
        <div id="chips_list_{{ $id }}" class="chips-list flex flex-wrap gap-2 items-center">
            {{-- Dirender oleh chips-loader.js --}}
        </div>

        <input type="text" id="input_{{ $id }}"
            class="chips-input bg-transparent border-none focus:ring-0 p-0 m-0 grow text-base-content min-w-[120px] placeholder:text-base-content/30 text-sm h-8"
            placeholder="{{ count($initialValues) === 0 ? $defaultPlaceholder : '' }}"
            autocomplete="off">
    </label>

    <div id="hidden_inputs_{{ $id }}" class="hidden-inputs"></div>
</div>
