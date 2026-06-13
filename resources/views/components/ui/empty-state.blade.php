@props(['icon' => 'info', 'message' => null])

<div {{ $attributes->merge(['class' => 'text-center py-10 opacity-50']) }}>
    <x-icons.icon :name="$icon" size="10" class="mx-auto mb-3 text-base-content" />
    <p class="text-xs italic text-base-content">
        {{ $message ?? $slot }}
    </p>
</div>
