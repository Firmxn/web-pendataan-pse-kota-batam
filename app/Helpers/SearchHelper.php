<?php

// Helper sanitasi parameter pencarian dan sorting sebelum masuk ke query database

if (!function_exists('escapeLike')) {
    /**
     * Escape karakter wildcard LIKE (% dan _) agar tidak disalahgunakan.
     * Mencegah resource exhaustion akibat wildcard mentah di query LIKE.
     *
     * @param mixed $value Input pencarian mentah dari pengguna
     * @return string Nilai yang sudah di-escape (\% dan \_)
     */
    function escapeLike(mixed $value): string
    {
        if (!is_scalar($value)) {
            return '';
        }

        $value = (string) $value;

        // Escape wildcard (% _) menjadi literal agar tidak cocok ke semua record
        return str_replace(['%', '_'], ['\\%', '\\_'], $value);
    }
}

if (!function_exists('normalizeSortDirection')) {
    /**
     * Whitelist arah sorting: hanya 'asc' atau 'desc' yang diterima.
     * Mencegah string liar masuk ke orderBy() dan menghindari SQL injection.
     *
     * @param mixed $value Input sort_dir mentah dari URL query
     * @param string $default Fallback jika input tidak valid (default: 'desc')
     * @return string Arah sorting yang sudah divalidasi
     */
    function normalizeSortDirection(mixed $value, string $default = 'desc'): string
    {
        if (!is_string($value)) {
            return $default;
        }

        $direction = strtolower((string) $value);

        // Whitelist: hanya 'asc' atau 'desc', selain itu fallback ke default
        return in_array($direction, ['asc', 'desc'], true) ? $direction : $default;
    }
}
