<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanStok extends Model
{
    protected $table = 'transaksi_stok';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = true;

    protected $fillable = [
        'id_bahan',
        'id_pengguna',
        'tanggal',
        'jumlah_bahan',
        'jenis_transaksi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}