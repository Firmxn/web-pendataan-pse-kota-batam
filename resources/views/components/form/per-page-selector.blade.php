{{--
|--------------------------------------------------------------------------
| KOMPONEN: PER PAGE SELECTOR
|--------------------------------------------------------------------------
| Komponen ini digunakan untuk memilih jumlah baris data yang ditampilkan
| per halaman (pagination). Secara otomatis mempertahankan filter pencarian
| dan pengurutan yang sedang aktif saat halaman diperbarui.
|
| MITIGASI KEAMANAN:
| 1. Parameter 'per_page' aman dari refleksi XSS langsung karena nilai option
|    hanya dirender dari whitelist '$options' yang statis. Input liar tidak
|    pernah dicetak langsung ke DOM.
| 2. Parameter filter terpreservasi dalam '$preservedParams' dicetak ke dalam
|    input hidden menggunakan '{{ $value }}' (Blade double curly braces).
|    Ini secara otomatis melakukan HTML escaping (fungsi e() Laravel) untuk
|    mencegah pemecahan atribut tag HTML (Mitigasi User Controllable Attribute XSS).
--}}

@props([
    'currentValue' => request('per_page', 10),
    'options' => [10, 25, 50, 100, 'all'],
])

@php
    // Kumpulkan parameter query string aktif (filter & sort) yang perlu dipertahankan
    // agar saat jumlah per_page diubah, filter pencarian atau tab tidak hilang.
    // Menghindari reset ke halaman 1 (page) untuk mencegah inkonsistensi pagination.
    $preservedParams = collect(request()->query())
        ->only(['search', 'status', 'tab', 'sort_by', 'sort_dir', 'month', 'year', 'category'])
        ->except(['per_page', 'page'])
        ->filter(fn ($value) => is_scalar($value) && $value !== '')
        ->all();
@endphp

<form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
    {{-- Sisipkan parameter filter aktif sebagai input hidden agar terikut dalam request GET --}}
    @foreach ($preservedParams as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <label for="per_page" class="text-sm text-base-content/70 whitespace-nowrap">
        {{ __('Tampilkan:') }}
    </label>

    {{-- Dropdown pemilihan limit. Memicu form submit otomatis secara instan saat opsi berubah (onchange) --}}
    <x-form.select name="per_page" id="per_page" data-auto-submit class="select-sm w-20! h-[30px] min-h-[30px] py-0">
        @foreach ($options as $option)
            <option value="{{ $option }}" {{ $currentValue == $option ? 'selected' : '' }}>
                {{ $option === 'all' ? __('Semua') : $option }}
            </option>
        @endforeach
    </x-form.select>
</form>
