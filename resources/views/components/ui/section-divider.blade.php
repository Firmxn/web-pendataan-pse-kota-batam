@props(['spacing' => true])

@php
    $spacingClass = $spacing ? 'mt-8' : '';
@endphp

<div {{ $attributes->merge(['class' => "divider divider-start divider-secondary dark:divider-accent font-medium text-base-content before:h-[1px] after:h-[1px] {$spacingClass}"]) }}>
    {{ $slot }}
</div>
