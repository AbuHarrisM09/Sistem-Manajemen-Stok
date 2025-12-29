<?php

namespace App\Services;

use App\Models\Bahan;
use App\Models\Pengguna;
use App\Models\LaporanStok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class StokManager
{
    public function catatStokMasuk(Bahan $bahan, int $jumlah, ?Pengguna $pengguna = null, ?string $keterangan = null): void
    {
        LaporanStok::create([
            'id_bahan' => $bahan->id_bahan,
            'id_pengguna' => ($pengguna?->id_pengguna) ?? (int) Auth::guard('pengguna')->id(),
            'tanggal' => now()->toDateString(),
            'jumlah_bahan' => $jumlah,
            'jenis_transaksi' => 'masuk',
            'keterangan' => $keterangan,
        ]);
    }

    public function catatStokKeluar(Bahan $bahan, int $jumlah, ?Pengguna $pengguna = null, ?string $keterangan = null): bool
    {
        if ($jumlah > $bahan->stok_saat_ini) {
            return false;
        }

        LaporanStok::create([
            'id_bahan' => $bahan->id_bahan,
            'id_pengguna' => ($pengguna?->id_pengguna) ?? (int) Auth::guard('pengguna')->id(),
            'tanggal' => now()->toDateString(),
            'jumlah_bahan' => $jumlah,
            'jenis_transaksi' => 'keluar',
            'keterangan' => $keterangan,
        ]);

        return true;
    }

    public function tambahBahanBaru(string $nama, int $stokAwal, int $stokMin): Bahan
    {
        $validator = Validator::make([
            'nama_bahan' => $nama,
            'stok_awal' => $stokAwal,
            'stok_minimum' => $stokMin,
        ], [
            'nama_bahan' => 'required|string|unique:bahan,nama_bahan',
            'stok_awal' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        $validator->validate();

        $bahan = Bahan::create([
            'nama_bahan' => $nama,
            'satuan' => 'pcs',
            'stok_minimum' => $stokMin,
        ]);

        if ($stokAwal > 0) {
            $this->catatStokMasuk($bahan, $stokAwal, null, 'Stok awal');
        }

        return $bahan;
    }

    public function ubahBahanBaru(string $nama, int $stokAwal, int $stokMin, ?Bahan $bahan = null): Bahan
    {
        $validator = Validator::make([
            'nama_bahan' => $nama,
            'stok_awal' => $stokAwal,
            'stok_minimum' => $stokMin,
        ], [
            'nama_bahan' => 'required|string',
            'stok_awal' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        $validator->validate();

        $target = $bahan ?? Bahan::create([
            'nama_bahan' => $nama,
            'satuan' => 'pcs',
            'stok_minimum' => $stokMin,
        ]);

        if ($bahan) {
            $target->update([
                'nama_bahan' => $nama,
                'stok_minimum' => $stokMin,
            ]);
        }

        $current = $target->stok_saat_ini;
        if ($stokAwal !== $current) {
            $diff = $stokAwal - $current;
            if ($diff > 0) {
                $this->catatStokMasuk($target, $diff, null, 'Penyesuaian stok');
            } elseif ($diff < 0) {
                $this->catatStokKeluar($target, abs($diff), null, 'Penyesuaian stok');
            }
        }

        return $target;
    }

    public function hapusBahan(Bahan $bahan, ?Pengguna $pengguna = null): Bahan
    {
        $bahan->delete();
        return $bahan;
    }

    public function getSemuaBahanStokMinimum(): \Illuminate\Support\Collection
    {
        return Bahan::all()->filter(fn (Bahan $b) => $b->stok_saat_ini <= $b->stok_minimum);
    }
}
