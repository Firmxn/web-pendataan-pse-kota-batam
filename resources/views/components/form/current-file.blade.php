@props(['document', 'label' => __('Lihat surat saat ini')])

@if ($document)
    <div {{ $attributes->merge(['class' => 'mt-1.5 text-xs text-primary flex items-center gap-2']) }}>
        <div class="flex-none">
            <x-icons.icon name="file-text" size="3" />
        </div>
        <a href="{{ route('documents.download', $document) }}" target="_blank"
            class="hover:underline font-medium hover:text-primary/80 transition-colors"
            title="{{ $document->original_name }}">
            <span class="opacity-80">{{ $label }}:</span>
            <span class="truncate max-w-[200px] inline-block align-bottom">
                {{ $document->original_name }}
            </span>
        </a>
    </div>
@endif
