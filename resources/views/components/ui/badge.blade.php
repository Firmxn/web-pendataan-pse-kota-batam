@props(['variant' => 'primary', 'size' => 'sm', 'outline' => false])

@php
    $variantClasses = [
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'neutral' => 'badge-neutral',
        'accent' => 'badge-accent',
        'info' => 'badge-info',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'error' => 'badge-error',
        'ghost' => 'badge-ghost',
    ];

    $sizeClasses = [
        'xs' => 'badge-xs',
        'sm' => 'badge-sm',
        'md' => 'badge-md',
        'lg' => 'badge-lg',
    ];

    $badgeClass = $variantClasses[$variant] ?? 'badge-primary';
    $sizeClass = $sizeClasses[$size] ?? 'badge-md';
    $outlineClass = $outline ? 'badge-outline' : '';
@endphp

<span {{ $attributes->merge(['class' => "badge badge-soft {$badgeClass} {$sizeClass} {$outlineClass} min-w-24 px-4"]) }}>
    {{ $slot }}
</span>
