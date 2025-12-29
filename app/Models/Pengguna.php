<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'nama',
        'password',
        'role',     // 'admin' | 'pegawai'
    ];

    protected $hidden = [
        'password',
    ];

    // Mutator: otomatis hash password
    public function setPasswordAttribute($value)
    {
        // hash buat password
        if ($value && strlen($value) === 60 && preg_match('/^\$2y\$/', $value)) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relasi
    public function transaksiStok()
    {
        return $this->hasMany(LaporanStok::class, 'id_pengguna');
    }

    public function laporanStok()
    {
        return $this->hasMany(LaporanPeriode::class, 'id_pengguna');
    }

    // Helper
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

   
    public static function login(string $username, string $password): bool
    {
        return \Illuminate\Support\Facades\Auth::guard('pengguna')->attempt([
            'username' => $username,
            'password' => $password,
        ]);
    }
}