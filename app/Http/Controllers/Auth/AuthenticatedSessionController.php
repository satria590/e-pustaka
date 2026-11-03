<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Proses autentikasi (cek email & password)
        $request->authenticate();

        // Regenerasi session untuk mencegah session fixation attack
        $request->session()->regenerate();

        // Setelah login berhasil:
        // 1. Kalau user sebelumnya mau buka halaman tertentu (misal klik "Pinjam"),
        //    Laravel otomatis simpan URL itu di session → redirect ke situ.
        // 2. Kalau tidak ada, redirect ke dashboard.
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout user dari guard 'web'
        Auth::guard('web')->logout();

        // Invalidasi session lama
        $request->session()->invalidate();

        // Buat ulang CSRF token biar aman
        $request->session()->regenerateToken();

        // Setelah logout, arahkan ke halaman katalog publik (bisa diakses guest)
        return redirect()->route('katalog');
    }
}