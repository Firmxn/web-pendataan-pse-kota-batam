@props(['disabled' => false])

@php
    // Auto-detect error berdasarkan name attribute
    $fieldName = $attributes->get('name');
    $hasError = false;

    if ($fieldName) {
        // Cek error di berbagai error bags
        $hasError =
            $errors->has($fieldName) ||
            $errors->updatePassword->has($fieldName) ||
            $errors->userDeletion->has($fieldName);
    }
@endphp

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'textarea w-full bg-base-100 rounded-xl transition-all duration-200 ' .
        ($disabled
            ? ' border border-base-200 opacity-60'
            : ($hasError
                ? ' border border-error focus:outline-none focus:ring-1 focus:ring-error/20'
                : ' border border-base-200 hover:border-base-300 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/20')),
]) !!}>{{ $slot }}
</textarea>
