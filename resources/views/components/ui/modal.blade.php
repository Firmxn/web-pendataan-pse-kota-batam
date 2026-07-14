@props([
    'id' => 'modal',
    'title' => '',
    'variant' => 'info',
    'size' => 'md',
    'useCustomJs' => false,
])

@php
    $variantClass = match ($variant) {
        'error' => 'text-error',
        'warning' => 'text-warning',
        'success' => 'text-success',
        'info' => 'text-info',
        default => 'text-base-content',
    };

    $sizeClass = match ($size) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        default => 'max-w-md',
    };
@endphp

<dialog id="{{ $id }}" class="modal">
    <div class="modal-box {{ $sizeClass }}">
        @if ($title)
            <x-ui.heading level="3" class="{{ $variantClass }}">{{ $title }}</x-ui.heading>
        @endif

        <div class="py-4">
            {{ $slot }}
        </div>

        <div class="modal-action">
            @if($useCustomJs)
                <x-button.ghost type="button" data-modal-close="{{ $id }}">Tutup</x-button.ghost>
            @else
                <form method="dialog">
                    <x-button.ghost>Tutup</x-button.ghost>
                </form>
            @endif
        </div>
    </div>
    @if(!$useCustomJs)
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
    @endif
</dialog>
