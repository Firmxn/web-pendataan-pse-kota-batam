<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi CORS yang telah diperketat untuk keamanan.
    | Hanya mengizinkan request dari domain resmi aplikasi (batam.go.id)
    | dan localhost untuk keperluan development.
    |
    | Dokumentasi: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // Path yang dikenai aturan CORS (route API dan CSRF token Laravel)
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // HTTP method yang diizinkan (dibatasi hanya yang digunakan aplikasi ini)
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    // Origin yang diizinkan: domain production + localhost untuk development
    // Nilai diambil dari APP_URL di .env agar otomatis menyesuaikan environment
    'allowed_origins' => array_filter([
        env('APP_URL'),                   // Otomatis dari .env (lokal atau production)
        'https://pse.batam.go.id',        // Domain production resmi
        'http://localhost',               // Development
        'http://localhost:8000',          // Development via php artisan serve
        'http://127.0.0.1:8000',          // Development via php artisan serve (alternatif)
        'http://localhost:8080',          // Development via Docker
    ]),

    'allowed_origins_patterns' => [],

    // Header yang diizinkan: dibatasi ke header yang benar-benar digunakan
    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Accept',
        'Authorization',
        'X-CSRF-TOKEN',
        // Header SSO Kota Batam (sesuai konfigurasi BBS_SSO_EXC_HEADER & BBS_SSO_PUB_HEADER)
        'X-SSO-Exclusive',
        'X-SSO-User',
    ],

    'exposed_headers' => [],

    // Cache preflight request selama 1 jam (3600 detik) untuk performa
    'max_age' => 3600,

    // Tidak menggunakan cookie lintas-origin (aplikasi ini berbasis SSO header, bukan cookie)
    'supports_credentials' => false,

];
