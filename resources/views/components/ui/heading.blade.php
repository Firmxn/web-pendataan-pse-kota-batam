@props(['level' => '2', 'size' => null])

@php
    // Default size per level
    $defaultSizes = [
        '1' => '3xl', // h1 - Judul utama halaman
        '2' => 'xl', // h2 - Section heading
        '3' => 'lg', // h3 - Sub-section
        '4' => 'base', // h4 - Minor heading
        '5' => 'sm', // h5 - Small heading
        '6' => 'xs', // h6 - Tiny heading
    ];

    $sizeClasses = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'base' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
        '3xl' => 'text-3xl',
        '4xl' => 'text-4xl',
    ];

    // Gunakan size custom atau default berdasarkan level
    $finalSize = $size ?? $defaultSizes[$level];
    $sizeClass = $sizeClasses[$finalSize] ?? 'text-xl';
    
    // Default base classes
    $baseClass = 'text-base-content leading-tight';
    
    // Specific styles for certain levels
    if ($level === '1') {
        $baseClass .= ' font-extrabold tracking-tight uppercase';
    } else {
        $baseClass .= ' font-semibold';
    }
@endphp

@if ($level === '1')
    <h1 {{ $attributes->merge(['class' => "{$baseClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </h1>
@elseif($level === '2')
    <h2 {{ $attributes->merge(['class' => "{$baseClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </h2>
@elseif($level === '3')
    <h3 {{ $attributes->merge(['class' => "{$baseClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </h3>
@elseif($level === '4')
    <h4 {{ $attributes->merge(['class' => "{$baseClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </h4>
@elseif($level === '5')
    <h5 {{ $attributes->merge(['class' => "{$baseClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </h5>
@else
    <h6 {{ $attributes->merge(['class' => "{$baseClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </h6>
@endif
