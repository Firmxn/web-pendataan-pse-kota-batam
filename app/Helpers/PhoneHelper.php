<?php

if (!function_exists('format_phone')) {
    /**
     * Format nomor telepon ke standar internasional Indonesia (+62)
     * e.g. 081234567890 -> +62 81-2345-67890
     *
     * @param string|null $phone
     * @return string
     */
    function format_phone($phone): string
    {
        if (!$phone) {
            return '-';
        }

        // Hapus karakter non-digit
        $phoneDigits = preg_replace('/[^0-9]/', '', $phone);

        // Jika nomor diawali 0, ganti dengan 62
        if ($phoneDigits && strpos($phoneDigits, '0') === 0) {
            $phoneDigits = '62' . substr($phoneDigits, 1);
        }

        // Jika nomor diawali 8 (misal 812...), tambahkan 62 di depan
        if ($phoneDigits && strpos($phoneDigits, '8') === 0) {
            $phoneDigits = '62' . $phoneDigits;
        }

        // Format: +62 8X-XXXX-XXXX... (minimal 10 digit setelah 62)
        if ($phoneDigits && strlen($phoneDigits) >= 10) {
            $prefix = '+62';
            $main = substr($phoneDigits, 2); // Ambil sisa setelah 62
            
            $part1 = substr($main, 0, 2);
            $part2 = substr($main, 2, 4);
            $part3 = substr($main, 6);
            
            return $prefix . ' ' . $part1 . '-' . $part2 . '-' . $part3;
        }

        return $phone ?? '-';
    }
}

if (!function_exists('normalize_phone')) {
    /**
     * Menormalisasi format nomor telepon ke angka bersih berawalan 62.
     *
     * @param string|null $phone
     * @return string|null
     */
    function normalize_phone($phone): ?string
    {
        if (!$phone) {
            return null;
        }

        // Hapus semua karakter selain angka
        $phoneDigits = preg_replace('/[^0-9]/', '', $phone);

        // Jika nomor diawali angka 0, ganti dengan kode negara 62
        if ($phoneDigits && strpos($phoneDigits, '0') === 0) {
            $phoneDigits = '62' . substr($phoneDigits, 1);
        }

        // Jika nomor diawali angka 8 (misal 812...), tambahkan 62 di depan
        if ($phoneDigits && strpos($phoneDigits, '8') === 0) {
            $phoneDigits = '62' . $phoneDigits;
        }

        return $phoneDigits;
    }
}
