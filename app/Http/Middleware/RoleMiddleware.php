<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('error', 'Akun Anda dinonaktifkan.');
        }

        // super_admin bypass semua otorisasi modul
        if ($user->hasRole('super_admin')) {
            return $next($request);
        }

        // Cek kecocokan role yang diizinkan untuk rute ini
        if (!empty($roles) && !$user->hasRole(...$roles)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk membuka modul ini.');
        }

        return $next($request);
    }
}