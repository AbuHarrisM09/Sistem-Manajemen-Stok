<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BahanController;
use App\Http\Controllers\Pegawai\TransaksiController; // ← tambahkan ini
use App\Http\Middleware\RoleMiddleware;

// Guest: hanya bisa ke login
Route::middleware('guest:pengguna')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Auth: semua yang login
Route::middleware('auth:pengguna')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // === ADMIN ONLY ===
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        // Dashboard Admin
        Route::get('/admin/dashboard', function () {
            $bahans = \App\Models\Bahan::all();
            return view('admin.dashboard', compact('bahans'));
        })->name('admin.dashboard');

        // CRUD Data Bahan (SRS 3.4.1.1–3.4.1.3)
        Route::resource('admin/bahan', BahanController::class)->names('admin.bahan');
    });

    // === PEGAWAI & ADMIN (boleh akses transaksi) ===
    Route::middleware([RoleMiddleware::class . ':pegawai,admin'])->group(function () {
        // Dashboard Pegawai
        Route::get('/pegawai/dashboard', function () {
            $bahans = \App\Models\Bahan::all();
            return view('pegawai.dashboard', compact('bahans'));
        })->name('pegawai.dashboard');

        // Transaksi Stok (SRS 3.4.1.4 & 3.4.1.5)
        Route::get('/transaksi/masuk', [TransaksiController::class, 'indexMasuk'])->name('transaksi.masuk');
        Route::post('/transaksi/masuk', [TransaksiController::class, 'storeMasuk']);
        Route::get('/transaksi/keluar', [TransaksiController::class, 'indexKeluar'])->name('transaksi.keluar');
        Route::post('/transaksi/keluar', [TransaksiController::class, 'storeKeluar']);
    });
});

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});