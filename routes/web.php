<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BahanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Pegawai\TransaksiController;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;

// Redirect root ke dashboard sesuai role atau login
Route::get('/', function () {
    if (Auth::guard('pengguna')->check()) {
        $user = Auth::guard('pengguna')->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'pegawai') {
            return redirect()->route('pegawai.dashboard'); // FIX: hilangkan spasi
        }
        return redirect()->route('login');
    }
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

    // Profil (Admin & Pegawai): kelola akun sendiri
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');

    // === ADMIN ONLY ===
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        // Dashboard Admin
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD Data Bahan + Manajemen Pegawai
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('bahan', BahanController::class);

            // Laporan Stok
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [LaporanController::class, 'index'])->name('index');
                Route::get('/export', [LaporanController::class, 'exportExcel'])->name('export');
                Route::get('/export-masuk', [LaporanController::class, 'exportMasuk'])->name('export.masuk');
                Route::get('/export-keluar', [LaporanController::class, 'exportKeluar'])->name('export.keluar');
            });

            // Manajemen Pegawai (tanpa status)
            Route::prefix('pegawai')->name('pegawai.')->group(function () {
                Route::get('/', [AdminUserController::class, 'index'])->name('index');
                Route::get('/create', [AdminUserController::class, 'create'])->name('create');
                Route::post('/', [AdminUserController::class, 'store'])->name('store');
                Route::get('/{pengguna}/edit', [AdminUserController::class, 'edit'])->name('edit');
                Route::put('/{pengguna}', [AdminUserController::class, 'update'])->name('update');
                Route::delete('/{pengguna}', [AdminUserController::class, 'destroy'])->name('destroy');
                // Tidak ada toggleActive karena kita tidak pakai status
            });
        });
    });

    // === PEGAWAI & ADMIN (boleh akses transaksi) ===
    Route::middleware([RoleMiddleware::class . ':pegawai,admin'])->group(function () {
        // Dashboard Pegawai
        Route::get('/pegawai/dashboard', [PegawaiDashboardController::class, 'index'])->name('pegawai.dashboard');

        // Transaksi Stok
        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::get('/masuk', [TransaksiController::class, 'indexMasuk'])->name('masuk');
            Route::post('/masuk', [TransaksiController::class, 'storeMasuk'])->name('masuk.store'); // FIX name
            Route::get('/keluar', [TransaksiController::class, 'indexKeluar'])->name('keluar');
            Route::post('/keluar', [TransaksiController::class, 'storeKeluar'])->name('keluar.store');
        });

        // Laporan untuk Pegawai (hanya view, tanpa export)
        Route::prefix('pegawai/laporan')->name('pegawai.laporan.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Pegawai\LaporanController::class, 'index'])->name('index');
        });
    });
});