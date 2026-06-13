@props([
    'document',
    'title',
    'icon' => 'file-text',
    'color' => 'primary',
])

@php
    $colorMap = [
        'primary' => 'bg-primary/5 border-primary/10 text-primary bg-primary/20',
        'accent' => 'bg-accent/5 border-accent/10 text-accent bg-accent/20',
        'secondary' => 'bg-secondary/5 border-secondary/10 text-secondary bg-secondary/20',
        'error' => 'bg-error/5 border-error/10 text-error bg-error/20',
        'warning' => 'bg-warning/5 border-warning/10 text-warning bg-warning/20',
        'info' => 'bg-info/5 border-info/10 text-info bg-info/20',
    ];

    $colors = explode(' ', $colorMap[$color] ?? $colorMap['primary']);
    $bgColor = $colors[0];
    $borderColor = $colors[1];
    $textColor = $colors[2];
    $iconBgColor = $colors[3];
@endphp

@if ($document)
    <a href="{{ route('documents.download', $document) }}" target="_blank"
        {{ $attributes->merge([
            'class' => "flex items-center justify-between p-3 rounded-xl $bgColor border $borderColor hover:opacity-80 transition-all group",
        ]) }}>
        <div class="flex items-center gap-3">
            <div class="p-2 {{ $iconBgColor }} {{ $textColor }} rounded-lg">
                <x-icons.icon :name="$icon" size="4" />
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold {{ $textColor }} uppercase tracking-wider leading-none mb-1">
                    {{ $title }}
                </p>
                <p class="text-[10px] text-base-content/60 truncate max-w-[140px]" title="{{ $document->original_name }}">
                    {{ $document->original_name }}
                </p>
            </div>
        </div>
        <x-icons.icon name="external-link" size="3"
            class="{{ $textColor }} opacity-40 group-hover:opacity-100 transition-opacity" />
    </a>
@endif
