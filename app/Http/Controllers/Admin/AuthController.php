<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'is_active' => true], $remember)) {
            $request->session()->regenerate();

            // CATAT LOG LOGIN BERHASIL
            ActivityLogger::log(
                'AUTH',
                'LOGIN',
                'Pengguna berhasil masuk ke sesi Backoffice'
            );

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name);
        }

        // CATAT LOG PERCOBAAN LOGIN GAGAL
        ActivityLogger::log(
            'AUTH',
            'FAILED_LOGIN',
            "Percobaan login gagal untuk email: {$credentials['email']}"
        );

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok, atau akun Anda sedang dinonaktifkan.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            // CATAT LOG LOGOUT
            ActivityLogger::log(
                'AUTH',
                'LOGOUT',
                'Pengguna keluar dari sesi Backoffice'
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar.');
    }
}