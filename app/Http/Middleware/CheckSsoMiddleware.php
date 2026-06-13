<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSsoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Middleware untuk SSO authentication berdasarkan header.
     * Header yang diterima:
     * - X-SSO-Exclusive: untuk internal user (role: petugas, verifikator_1, verifikator_2)
     * - X-SSO-User: untuk publik (role: publik)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check header SSO
        $userHeader = config('auth.sso.user_header');
        $pubHeader = config('auth.sso.pub_header');
        $emailFromHeader = $request->header($userHeader) ?? $request->header($pubHeader);

        // Jika tidak ada header SSO, return 403
        if (!$emailFromHeader) {
            abort(401, 'Unauthorized. Missing SSO header.');
            // return response()->json([
            //     'message' => 'Unauthorized. Missing SSO header.',
            // ], 401);
        }


        // Find user by email
        $user = User::where('email', $emailFromHeader)->first();

        // Jika user tidak ditemukan, return 403
        if (!$user) {
            abort(401, 'Unauthorized. User not found.');
            // return response()->json([
            //     'message' => 'Unauthorized. User not found.',
            // ], 401);
        }

        // Validasi role berdasarkan header
        // X-SSO-Exclusive: untuk internal user (petugas, verifikator_1, verifikator_2)
        // X-SSO-User: untuk publik
        $internalRoles = ['petugas', 'verifikator_1', 'verifikator_2', 'eksekutif', 'admin'];

        if ($request->header($userHeader)) {
            // Header X-SSO-Exclusive harus role internal (petugas/verifikator_1/verifikator_2)
            if (!in_array($user->role->role_name, $internalRoles)) {
                abort(403, 'Forbidden. You do not have the required role.');
                // return response()->json([
                //     'message' => 'Forbidden. You do not have the required role.',
                // ], 403);
            }
        } else {
            // Header X-SSO-User: Akses publik belum tersedia
            abort(403, 'Public access is not yet available.');
            // return response()->json([
            //     'message' => 'Public access is not yet available.',
            // ], 403);
        }

        // Deteksi perubahan role
        // Jika user sudah login sebelumnya dengan role berbeda, redirect ke dashboard
        if (Auth::check()) {
            $currentRole = Auth::user()->role->role_name;
            $newRole = $user->role->role_name;

            if ($currentRole !== $newRole) {
                // Role berubah, logout user lama dan login user baru
                Auth::logout();
                session()->flush();
                Auth::login($user);

                // Redirect ke dashboard untuk mencegah akses halaman role lama
                return redirect()->route('dashboard');
            }
        }

        // Auto-login user (jika belum login atau role sama)
        if (!Auth::check()) {
            Auth::login($user);
        }

        return $next($request);
    }
}
