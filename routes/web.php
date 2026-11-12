<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== ROUTE PUBLIC (TANPA LOGIN) ====================

// Halaman Utama (Landing Page)
Route::get('/', function () {
    $bukus = \App\Models\Buku::latest()->take(4)->get();
    return view('welcome', compact('bukus'));
})->name('home');

// Halaman Katalog (Untuk Guest)
Route::get('/katalog', [BukuController::class, 'index'])->name('katalog');
Route::get('/katalog/search', [BukuController::class, 'search'])->name('katalog.search');
Route::get('/katalog/{buku}', [BukuController::class, 'show'])->name('katalog.show');


// ==================== ROUTE PRIVATE (HARUS LOGIN) ====================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // MANAJEMEN BUKU
    // ==========================================
    // PENTING: Route Search harus di ATAS Route::resource
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::resource('buku', BukuController::class);

    // ==========================================
    // MANAJEMEN PEMINJAMAN
    // ==========================================
    // PENTING: Route Laporan harus di ATAS Route::resource
    Route::get('/peminjaman/laporan', [PeminjamanController::class, 'laporan'])->name('peminjaman.laporan');
    Route::resource('peminjaman', PeminjamanController::class);
    
    // Route Tambahan Peminjaman
    Route::get('/peminjaman/kembali/{id}', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');
    Route::get('/peminjaman/form-ajukan/{buku}', [PeminjamanController::class, 'formAjukan'])->name('peminjaman.form_ajukan');
    
    // FITUR BARU: Verifikasi & Tolak (Anti-Bentrok)
    Route::get('/peminjaman/verifikasi/{id}', [PeminjamanController::class, 'verifikasi'])->name('peminjaman.verifikasi');
    Route::get('/peminjaman/tolak/{id}', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
    
    // Laporan Dashboard (opsional)
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
});

require __DIR__ . '/auth.php';