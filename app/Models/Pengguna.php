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
        'active',   // optional boolean, jika Anda pakai status aktif/nonaktif
    ];

    protected $hidden = [
        'password',
    ];

    // Mutator: otomatis hash password
    public function setPasswordAttribute($value)
    {
        // Jika value sudah di-hash (misal panjang 60 untuk bcrypt), jangan di-hash ulang
        if ($value && strlen($value) === 60 && preg_match('/^\$2y\$/', $value)) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relasi (opsional, sesuaikan jika tabel relasi ada)
    public function transaksiStok()
    {
        return $this->hasMany(TransaksiStok::class, 'id_pengguna');
    }

    public function laporanStok()
    {
        return $this->hasMany(LaporanStok::class, 'id_pengguna');
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
}