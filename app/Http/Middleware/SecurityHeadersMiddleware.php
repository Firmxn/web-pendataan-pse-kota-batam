<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // X-Content-Type-Options: Cegah MIME type sniffing
        // Browser tidak akan mencoba "menebak" tipe file
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection: Aktifkan browser XSS filter
        // Browser akan block page jika detect XSS attack
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy: Kontrol informasi referrer
        // Hanya kirim origin saat cross-origin request
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // X-Frame-Options: Cegah clickjacking
        // Page hanya bisa di-frame oleh same origin
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Hapus header X-Powered-By agar versi PHP tidak terekspos
        $response->headers->remove('X-Powered-By');

        // HTTPS Strict-Transport-Security (HSTS): Paksa browser menggunakan HTTPS
        // Mencegah downgrade attack (HTTP) dan cookie hijacking
        // max-age=31536000 (1 tahun), includeSubDomains
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Permissions-Policy: Batasi fitur browser yang bisa diakses
        // Mencegah penyalahgunaan API sensitif jika ada XSS
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=(), vr=()');

        // Content-Security-Policy: Batasi sumber konten yang diizinkan
        // Mencegah XSS dan data injection attack
        $viteUrl = 'http://127.0.0.1:5173';
        $viteWsUrl = 'ws://127.0.0.1:5173';
        $isDev = !app()->environment('production');

        $csp = [
            "default-src 'self'",
            "script-src 'self' " . ($isDev ? $viteUrl : ""),
            "style-src 'self' " . ($isDev ? "'unsafe-inline' {$viteUrl}" : ""),
            "font-src 'self' data:",
            "img-src 'self' data:",
            "connect-src 'self' " . ($isDev ? "{$viteUrl} {$viteWsUrl}" : ""),
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', array_filter($csp)));

        return $response;
    }
}
