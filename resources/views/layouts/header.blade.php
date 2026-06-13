<div class="navbar bg-base-100 shadow-sm sticky top-0 z-30 px-4">
    <div class="flex-none">
        <label for="my-drawer-4" aria-label="open sidebar" class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </label>
    </div>

    <div class="flex-1 px-2 mx-2">
        @if (isset($header))
            {{ $header }}
        @else
            <span class="font-semibold text-xl text-base-content">{{ config('app.name', 'Laravel') }}</span>
        @endif
    </div>

    <div class="flex-none gap-2">
        {{-- Profile moved to Sidebar --}}
    </div>
</div>
