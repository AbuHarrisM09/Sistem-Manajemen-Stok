<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BahanController; // ← tambahkan ini
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

        // CRUD Data Bahan (sesuai SRS 3.4.1.1–3.4.1.3)
        Route::get('/admin/bahan', [BahanController::class, 'index'])->name('admin.bahan.index');
        Route::get('/admin/bahan/create', [BahanController::class, 'create'])->name('admin.bahan.create');
        Route::post('/admin/bahan', [BahanController::class, 'store'])->name('admin.bahan.store');
        Route::get('/admin/bahan/{bahan}/edit', [BahanController::class, 'edit'])->name('admin.bahan.edit');
        Route::put('/admin/bahan/{bahan}', [BahanController::class, 'update'])->name('admin.bahan.update');
        Route::delete('/admin/bahan/{bahan}', [BahanController::class, 'destroy'])->name('admin.bahan.destroy');
    });

    // === PEGAWAI ONLY ===
    Route::middleware([RoleMiddleware::class . ':pegawai'])->group(function () {
        Route::get('/pegawai/dashboard', function () {
            $bahans = \App\Models\Bahan::all();
            return view('pegawai.dashboard', compact('bahans'));
        })->name('pegawai.dashboard');
    });
});

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});