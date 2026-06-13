@props(['value', 'field' => null])

@php
    $hasError = false;
    if ($field) {
        // Cek default error bag
        $hasError = $errors->has($field);

        // Cek error bags lainnya (updatePassword, userDeletion, dll)
        if (!$hasError && $errors->getBags()) {
            foreach ($errors->getBags() as $bag) {
                if ($bag->has($field)) {
                    $hasError = true;
                    break;
                }
            }
        }
    }
@endphp

@if ($value && (!$field || !$hasError))
    <p {{ $attributes->merge(['class' => 'label text-xs']) }}>
        {{ $value }}
    </p>
@endif
