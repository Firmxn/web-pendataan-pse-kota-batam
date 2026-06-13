@props(['light' => false, 'icon' => null])

<label {{ $attributes->merge(['class' => ($light ? 'text-xs font-semibold text-base-content/50 uppercase tracking-wider flex items-center gap-1.5' : 'text-xs font-bold text-base-content flex items-center gap-2 mb-1 uppercase tracking-wider text-[10px]')]) }}>
    @if($icon)
        <x-icons.icon :name="$icon" size="3" class="opacity-80" />
    @endif
    {{ $slot }}
</label>
