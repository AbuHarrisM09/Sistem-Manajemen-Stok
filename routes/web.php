<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BahanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Pegawai\TransaksiController;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;

// Redirect root ke dashboard sesuai role atau login
Route::get('/', function () {
    if (Auth::guard('pengguna')->check()) {
        $user = Auth::guard('pengguna')->user();
        
        // Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'pegawai') {
            return redirect()->route('pegawai. dashboard');
        }
        
        // Fallback jika role tidak dikenali
        return redirect()->route('login');
    }
    
    // Belum login → ke login
    return redirect()->route('login');
});

// Guest: hanya bisa ke login
Route::middleware('guest:pengguna')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Auth: semua yang login
Route::middleware('auth:pengguna')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // === ADMIN ONLY ===
    Route::middleware([RoleMiddleware::class .  ':admin'])->group(function () {
        // Dashboard Admin
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD Data Bahan
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('bahan', BahanController::class);
        });
    });

    // === PEGAWAI & ADMIN (boleh akses transaksi) ===
    Route::middleware([RoleMiddleware::class . ':pegawai,admin'])->group(function () {
        // Dashboard Pegawai
        Route::get('/pegawai/dashboard', [PegawaiDashboardController::class, 'index'])->name('pegawai.dashboard');

        // Transaksi Stok
        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::get('/masuk', [TransaksiController::class, 'indexMasuk'])->name('masuk');
            Route::post('/masuk', [TransaksiController::class, 'storeMasuk'])->name('masuk. store');
            
            Route::get('/keluar', [TransaksiController::class, 'indexKeluar'])->name('keluar');
            Route::post('/keluar', [TransaksiController::class, 'storeKeluar'])->name('keluar.store');
        });
    });
});