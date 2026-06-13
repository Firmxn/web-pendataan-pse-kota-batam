@props([
    'title' => '',
    'value' => 0,
    'color' => 'primary', // success, info, warning, primary, secondary
    'trend' => null,
    'trendLabel' => '',
    'isGradient' => false,
    'url' => '#',
])

@php
    $baseClasses = "relative overflow-hidden rounded-[2rem] p-8 transition-[transform,box-shadow] duration-500 hover:scale-[1.02] hover:shadow-2xl group";
    
    if ($isGradient) {
        $bgClasses = [
            'success' => 'bg-gradient-to-br from-success to-success/80 text-success-content shadow-success/30',
            'info' => 'bg-gradient-to-br from-info to-info/80 text-info-content shadow-info/30',
            'primary' => 'bg-gradient-to-br from-primary to-primary/80 text-primary-content shadow-primary/30',
            'accent' => 'bg-gradient-to-br from-accent to-accent/80 text-accent-content shadow-accent/30',
        ][$color] ?? 'bg-gradient-to-br from-neutral to-neutral-focus text-neutral-content';
    } else {
        $bgClasses = "card bg-base-100 shadow-sm border border-base-200/50 text-base-content";
    }
@endphp

<div {{ $attributes->merge(['class' => "$baseClasses $bgClasses"]) }}>
    {{-- Decorative Background Elements (Glassmorphism effect) --}}
    @if($isGradient)
        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 h-32 w-32 rounded-full bg-black/10 blur-3xl"></div>
    @endif

    <div class="relative z-10 flex flex-col h-full">
        <div class="flex justify-between items-start mb-6">
            <h3 class="text-lg font-medium tracking-tight opacity-90 leading-tight">{{ __($title) }}</h3>
            
            <div class="flex items-center gap-3">
                @if(isset($action))
                    <div>
                        {{ $action }}
                    </div>
                @endif

                @if($url && $url !== '#')
                    @php
                        $iconHoverClasses = $isGradient 
                            ? "group-hover:bg-base-100 group-hover:text-primary group-hover:border-base-100" 
                            : "group-hover:bg-primary group-hover:text-base-100 group-hover:border-primary";
                    @endphp
                    <a href="{{ $url }}" class="flex h-10 w-10 items-center justify-center rounded-full border border-current opacity-20 transform transition-all duration-300 {{ $iconHoverClasses }} group-hover:opacity-100 group-hover:rotate-12 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-auto">
            <div class="text-6xl font-bold tracking-tighter mb-4">{{ $value }}</div>
            
            <div class="flex items-center gap-2">
                @if($trend !== null)
                    <div class="flex items-center gap-1 text-sm font-semibold rounded-full px-3 py-1 {{ $isGradient ? 'bg-white/10 text-white ring-1 ring-white/20' : "bg-{$color}/10 text-{$color}" }}">
                        <span class="inline-flex items-center justify-center rounded-md border border-current p-0.5 text-[10px]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 4l-8 8h16l-8-8z" />
                            </svg>
                        </span>
                        <span>{{ $trend }}</span>
                        @if($trendLabel)
                            <span class="opacity-60 ml-0.5 font-normal tracking-wide">{{ __($trendLabel) }}</span>
                        @endif
                    </div>
                @else
                    <div class="text-sm font-medium opacity-60 italic tracking-wide">
                        {{ __('Tidak ada perubahan dari bulan lalu') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
