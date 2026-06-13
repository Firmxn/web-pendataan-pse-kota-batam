@if (session('success'))
    <div class="alert alert-success mb-4 border-none shadow-sm rounded-2xl">
        <x-icons.icon name="check" size="5" />
        <span>
            {{ session('success') }}
        </span>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error mb-4 border-none shadow-sm rounded-2xl">
        <x-icons.icon name="alert-triangle" size="5" />
        <span>
            {!! \Illuminate\Support\Str::of(e(session('error')))->replace(
                ['**', '**/'],
                ['<span class="font-bold">', '</span>'],
            ) !!}
        </span>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error mb-4 border-none shadow-sm rounded-2xl flex-col items-start gap-1">
        <div class="flex items-center gap-2">
            <x-icons.icon name="alert-triangle" size="5" />
            <span class="font-semibold">{{ __('Terdapat beberapa kesalahan input:') }}</span>
        </div>
        <ul class="list-disc list-inside ml-7 text-sm opacity-90">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
