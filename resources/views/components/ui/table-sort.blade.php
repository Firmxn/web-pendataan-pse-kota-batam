{{--
|--------------------------------------------------------------------------
| KOMPONEN: TABLE SORT
|--------------------------------------------------------------------------
| Komponen header tabel (<th>) yang mendukung pengurutan kolom secara dinamis.
| Menampilkan indikator arah pengurutan (panah atas/bawah) dan menyusun URL
| yang mempertahankan filter pencarian serta paginasi yang sedang aktif.
|
| MITIGASI KEAMANAN:
| 1. Memitigasi alert "User Controllable HTML Element Attribute (Potential XSS)"
|    dengan melakukan sanitasi dan membatasi parameter 'sort_dir' hanya pada 
|    nilai whitelist ('asc' dan 'desc'), serta parameter 'sort_by' yang terikat
|    hanya pada field-field kolom valid.
| 2. Mencegah eksploitasi "SQL/orderBy manipulation" di tingkat database
|    dengan membatasi query parameter liar agar tidak masuk langsung ke method
|    orderBy() Laravel.
--}}

@props(['field', 'label'])

@php
    // Daftar parameter filter/pencarian tepercaya yang diizinkan untuk dipertahankan di URL.
    // Menghindari eksploitasi parameter URL yang tidak terdaftar (XSS mitigation).
    $allowedQueryKeys = ['search', 'status', 'tab', 'per_page', 'month', 'year', 'category'];

    $currentSort = request('sort_by');
    $currentDir = in_array(request('sort_dir'), ['asc', 'desc'], true) ? request('sort_dir') : 'asc';

    // Periksa apakah kolom ini merupakan kolom pengurutan yang sedang aktif
    $isActive = $currentSort === $field;

    // Tentukan arah pengurutan berikutnya:
    // Jika kolom sudah aktif dan berarah 'asc', ubah menjadi 'desc'. Selain itu, default ke 'asc'.
    $nextDir = $isActive && $currentDir === 'asc' ? 'desc' : 'asc';

    // Filter parameter URL aktif agar hanya menyimpan filter yang valid/tepercaya
    $params = collect(request()->query())
        ->only($allowedQueryKeys)
        ->filter(fn($value) => is_scalar($value) && $value !== '')
        ->all();

    // Gabungkan parameter filter yang ada dengan instruksi pengurutan baru
    $params = array_merge($params, [
        'sort_by' => $field,
        'sort_dir' => $nextDir,
    ]);

    // Susun URL lengkap yang akan digunakan pada tautan link header kolom
    $url = request()->fullUrlWithQuery($params);
@endphp

<th {{ $attributes->merge(['class' => 'p-0']) }}>
    <a href="{{ $url }}"
        class="flex items-center justify-between gap-2 w-full h-full px-4 py-3 hover:bg-base-300 transition-colors group">

        {{-- Label nama kolom --}}
        <span class="font-semibold text-sm whitespace-nowrap">{{ $label }}</span>

        {{-- Indikator arah panah pengurutan (Ascending / Descending) --}}
        <div class="flex flex-col shrink-0 select-none items-center justify-center -space-y-3">
            {{-- Panah Atas (Ascending) --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-4 h-4 {{ $isActive && $currentDir === 'asc' ? 'text-primary opacity-100' : 'text-base-content/20 group-hover:text-base-content/40' }}">
                <path d="M12 6l-6 8h12l-6-8z" />
            </svg>

            {{-- Panah Bawah (Descending) --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-4 h-4 {{ $isActive && $currentDir === 'desc' ? 'text-primary opacity-100' : 'text-base-content/20 group-hover:text-base-content/40' }}">
                <path d="M12 18l6-8H6l6 8z" />
            </svg>
        </div>
    </a>
</th>
