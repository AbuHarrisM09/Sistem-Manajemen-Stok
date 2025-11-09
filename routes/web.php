<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RoleMiddleware;

// Guest: hanya bisa ke login
Route::middleware('guest:pengguna')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Auth: semua yang login
Route::middleware('auth:pengguna')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin
    Route::middleware([RoleMiddleware::class . ':admin'])
        ->get('/admin/dashboard', function () {
            $bahans = \App\Models\Bahan::all();
            return view('admin.dashboard', compact('bahans'));
        })->name('admin.dashboard');

    // Pegawai
    Route::middleware([RoleMiddleware::class . ':pegawai'])
        ->get('/pegawai/dashboard', function () {
            $bahans = \App\Models\Bahan::all();
            return view('pegawai.dashboard', compact('bahans'));
        })->name('pegawai.dashboard');
});

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});