@props(['document', 'label' => __('Berkas saat ini:')])

@if ($document)
    <div {{ $attributes->merge(['class' => 'mt-2 p-3 bg-base-200 dark:bg-base-200 rounded-md']) }}>
        <div class="flex items-center justify-between gap-4 text-sm text-base-content">
            <div class="flex items-center gap-2 whitespace-nowrap shrink-0">
                <span>📄</span>
                <span>{{ $label }}</span>
            </div>
            <div class="flex items-center gap-2 min-w-0 justify-end">
                <a href="{{ route('documents.download', $document) }}" target="_blank"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline transition-colors truncate inline-block max-w-[160px] sm:max-w-xs md:max-w-sm"
                    title="{{ $document->original_name }}">
                    {{ $document->original_name }}
                </a>
                <a href="{{ route('documents.download', $document) }}" target="_blank"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endif
