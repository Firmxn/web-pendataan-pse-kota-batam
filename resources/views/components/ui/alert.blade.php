@props([
    'variant' => 'info', // info, success, warning, error
    'icon' => null,
    'title' => null,
    'dismissible' => false,
])

@php
    $variantClasses = match ($variant) {
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'error' => 'alert-error',
        'primary' => 'bg-primary text-primary-content border-none',
        default => 'alert-info',
    };

    $iconName = $icon ?? match ($variant) {
        'success' => 'check-circle',
        'warning' => 'alert-triangle',
        'error' => 'x-circle',
        'primary' => 'check',
        default => 'info',
    };
@endphp

<div role="alert" {{ $attributes->merge(['class' => "alert {$variantClasses} rounded-3xl shadow-sm border p-5 flex items-start gap-4 transition-all duration-300"]) }}>
    <div class="mt-0.5 shrink-0">
        <x-icons.icon :name="$iconName" size="6" />
    </div>
    
    <div class="flex-1">
        @if ($title)
            <h4 class="font-bold text-base mb-1">{{ $title }}</h4>
        @endif
        
        <div class="text-sm font-medium leading-relaxed">
            {{ $slot }}
        </div>
    </div>

    @if ($dismissible)
        <button type="button" class="btn btn-ghost btn-xs btn-circle opacity-50 hover:opacity-100" data-dismiss="alert">
            <x-icons.icon name="x" size="4" />
        </button>
    @endif
</div>
