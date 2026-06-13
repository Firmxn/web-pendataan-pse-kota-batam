@props(['type'])

@php
    $normalizedType = \Illuminate\Support\Str::lower($type);
    $typeVariants = [
        'baru' => 'info',
        'perpanjangan' => 'accent',
        'ubah' => 'warning',
        'hapus' => 'error',
    ];

    $variant = $typeVariants[$normalizedType] ?? 'neutral';
@endphp

<x-ui.badge variant="{{ $variant }}" {{ $attributes }}>
    {{ __(ucfirst($type)) }}
</x-ui.badge>