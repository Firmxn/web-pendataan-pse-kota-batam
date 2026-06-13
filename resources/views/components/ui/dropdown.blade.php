@props(['align' => 'right', 'width' => '52'])

@php
$alignmentClasses = match($align) {
    'left' => 'dropdown-start',
    'top' => 'dropdown-top',
    'right' => 'dropdown-end',
    default => 'dropdown-end',
};

$widthClass = match($width) {
    '48' => 'w-48',
    '52' => 'w-52',
    '64' => 'w-64',
    default => 'w-52',
};
@endphp

<div class="dropdown {{ $alignmentClasses }}">
    <div tabindex="0" role="button">
        {{ $trigger }}
    </div>
    <ul tabindex="-1" class="dropdown-content menu bg-base-100 rounded-box z-50 {{ $widthClass }} p-2 shadow">
        {{ $content }}
    </ul>
</div>
