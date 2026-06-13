@props(['status'])

{{-- Draft khusus: secondary di light mode, accent di dark mode --}}
@if ($status === 'draft')
    <x-ui.badge variant="secondary" {{ $attributes->merge(['class' => 'dark:badge-accent']) }}>
        {{ ucfirst($status) }}
    </x-ui.badge>
@else
    <x-ui.badge variant="{{ status_badge_variant($status) }}" {{ $attributes }}>
        {{ ucfirst($status) }}
    </x-ui.badge>
@endif
