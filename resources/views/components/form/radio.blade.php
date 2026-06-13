@props(['name', 'label' => null, 'value' => null, 'checked' => false, 'disabled' => false])

@php
    $fieldName = $attributes->get('name', $name ?? '');
    $hasError = $errors->has($fieldName);
@endphp

<label class="label cursor-pointer flex items-center gap-3 justify-start">
    <input 
        type="radio" 
        name="{{ $name }}" 
        value="{{ $value }}" 
        {{ $disabled ? 'disabled' : '' }}
        {{ $checked ? 'checked' : '' }} 
        {!! $attributes->merge([
            'class' => 'radio radio-primary radio-xs transition-all duration-200' . ($hasError ? ' radio-error' : '')
        ]) !!}
    />
    @if($label)
        <span class="label-text text-primary text-xs md:text-base font-normal">
            {{ $label }}
        </span>
    @endif
</label>
