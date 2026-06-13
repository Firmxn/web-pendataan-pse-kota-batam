<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSsoOptionalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Middleware untuk SSO authentication OPTIONAL (untuk halaman publik).
     * Jika ada header SSO, lakukan auto-login.
     * Jika tidak ada header SSO, logout user (clear stale session).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check header SSO
        $userHeader = config('auth.sso.user_header');
        $pubHeader = config('auth.sso.pub_header');
        $emailFromHeader = $request->header($userHeader) ?? $request->header($pubHeader);

        // Jika tidak ada header SSO
        if (!$emailFromHeader) {
            // Logout jika ada session lama (clear stale session)
            if (Auth::check()) {
                Auth::logout();
                session()->flush();
            }
            return $next($request);
        }

        // Jika ada header SSO, cari user
        $user = User::where('email', $emailFromHeader)->first();

        // Jika user tidak ditemukan, logout dan lanjutkan
        if (!$user) {
            if (Auth::check()) {
                Auth::logout();
                session()->flush();
            }
            return $next($request);
        }

        // Validasi role berdasarkan header (sama seperti CheckSsoMiddleware)
        $internalRoles = ['petugas', 'verifikator_1', 'verifikator_2', 'eksekutif', 'admin'];

        if ($request->header($userHeader)) {
            // Header X-SSO-Exclusive harus role internal
            if (!in_array($user->role->role_name, $internalRoles)) {
                if (Auth::check()) {
                    Auth::logout();
                    session()->flush();
                }
                return $next($request);
            }
        } else {
            // Header X-SSO-User: belum tersedia
            if (Auth::check()) {
                Auth::logout();
                session()->flush();
            }
            return $next($request);
        }

        // Deteksi perubahan role (sama seperti CheckSsoMiddleware)
        if (Auth::check()) {
            $currentRole = Auth::user()->role->role_name;
            $newRole = $user->role->role_name;

            if ($currentRole !== $newRole) {
                Auth::logout();
                session()->flush();
                Auth::login($user);
            }
        }

        // Auto-login user jika belum login
        if (!Auth::check()) {
            Auth::login($user);
        }

        return $next($request);
    }
}
