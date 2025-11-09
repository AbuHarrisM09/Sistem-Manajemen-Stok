<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $table = 'bahan';
    protected $primaryKey = 'id_bahan';
    public $timestamps = true;

    protected $fillable = [
        'nama_bahan',
        'satuan',
        'stok_minimum',
    ];

    // Relasi
    public function transaksiStok()
    {
        return $this->hasMany(TransaksiStok::class, 'id_bahan');
    }

    // 💡 Hitung stok real-time (tidak simpan di DB)
    public function getStokSaatIniAttribute(): int
    {
        $masuk = $this->transaksiStok()
            ->where('jenis_transaksi', 'masuk')
            ->sum('jumlah_bahan');

        $keluar = $this->transaksiStok()
            ->where('jenis_transaksi', 'keluar')
            ->sum('jumlah_bahan');

        return $masuk - $keluar;
    }

    // Status stok (untuk warna di dashboard)
    public function getStatusStokAttribute(): string
    {
        $stok = $this->stok_saat_ini;
        if ($stok <= 0) return 'habis';
        if ($stok <= $this->stok_minimum) return 'menipis';
        return 'normal';
    }
}