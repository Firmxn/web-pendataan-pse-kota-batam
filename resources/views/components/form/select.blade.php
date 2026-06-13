@props(['disabled' => false, 'size' => 'md'])

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

    // Variasi ukuran
    $sizeClasses = match ($size) {
        'sm' => 'select-sm w-full h-[30px]',
        'lg' => 'select-lg',
        default => '',
    };
@endphp

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        // 'select w-full shadow-xs transition-shadow duration-200 ' .
        'select w-full bg-base-100 rounded-xl transition-all duration-200 ' .
        $sizeClasses .
        ($disabled
            ? // ? ' border-0'
            ' border border-base-200 opacity-60'
            : ($hasError
                ? //             ? ' select-error focus:outline-none focus:ring-2 focus:ring-error/20'
                // : ' select-bordered focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20')),
                ' border border-error focus:outline-none focus:ring-1 focus:ring-error/20'
                : ' border border-base-200 hover:border-base-300 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/20')),
]) !!}>{{ $slot }}
</select>
