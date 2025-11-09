<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    // 🔐 Mutator: otomatis hash password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Relasi
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
}