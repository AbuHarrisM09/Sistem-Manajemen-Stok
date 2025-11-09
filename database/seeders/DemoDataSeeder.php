<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Bahan;
use App\Models\TransaksiStok;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // Admin & Pegawai
        $admin = Pengguna::create([
            'username' => 'admin',
            'password' => 'password123',
            'role' => 'admin'
        ]);

        $pegawai = Pengguna::create([
            'username' => 'pegawai',
            'password' => 'password123',
            'role' => 'pegawai'
        ]);

        // Bahan
        $tepung = Bahan::create(['nama_bahan' => 'Tepung Terigu', 'satuan' => 'kg', 'stok_minimum' => 10]);
        $minyak = Bahan::create(['nama_bahan' => 'Minyak Goreng', 'satuan' => 'liter', 'stok_minimum' => 5]);
        $gula = Bahan::create(['nama_bahan' => 'Gula Pasir', 'satuan' => 'kg', 'stok_minimum' => 8]);

        // Transaksi
        TransaksiStok::create([
            'id_bahan' => $tepung->id_bahan,
            'id_pengguna' => $admin->id_pengguna,
            'tanggal' => Carbon::today(),
            'jumlah_bahan' => 20,
            'jenis_transaksi' => 'masuk',
            'keterangan' => 'Stok awal'
        ]);

        TransaksiStok::create([
            'id_bahan' => $tepung->id_bahan,
            'id_pengguna' => $pegawai->id_pengguna,
            'tanggal' => Carbon::today(),
            'jumlah_bahan' => 5,
            'jenis_transaksi' => 'keluar',
            'keterangan' => 'Produksi'
        ]);

        TransaksiStok::create([
            'id_bahan' => $minyak->id_bahan,
            'id_pengguna' => $admin->id_pengguna,
            'tanggal' => Carbon::today(),
            'jumlah_bahan' => 10,
            'jenis_transaksi' => 'masuk',
            'keterangan' => 'Stok awal minyak'
        ]);
    }
}