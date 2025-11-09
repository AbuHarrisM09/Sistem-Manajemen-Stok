<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanStok extends Model
{
    protected $table = 'laporan_stok';
    protected $primaryKey = 'id_laporan';
    public $timestamps = true;

    protected $fillable = [
        'id_pengguna',
        'periode_awal',
        'periode_akhir',
        'tanggal_cetak',
    ];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
        'tanggal_cetak' => 'date',
    ];

    // Relasi
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}