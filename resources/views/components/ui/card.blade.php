@props(['title' => null, 'padding' => true, 'icon' => null])

@php
    $paddingClass = $padding ? 'px-8 py-8' : '';
@endphp

<div {{ $attributes->merge(['class' => 'card bg-base-100 shadow-sm border border-base-200/50 rounded-4xl transition-[transform,box-shadow] duration-500 hover:scale-[1.01] hover:shadow-2xl']) }}>
    @if ($title)
        <div class="card-body {{ $paddingClass }}">
            <div class="flex items-center gap-2 mb-4">
                @if($icon)
                    <div class="p-2 rounded-lg bg-primary/10 text-primary">
                        <x-icons.icon :name="$icon" size="4" />
                    </div>
                @endif
                <h3 class="card-title text-sm font-bold tracking-tight text-base-content/70 uppercase">{{ $title }}</h3>
            </div>
            {{ $slot }}
        </div>
    @else
        <div class="card-body {{ $paddingClass }}">
            {{ $slot }}
        </div>
    @endif
</div>
