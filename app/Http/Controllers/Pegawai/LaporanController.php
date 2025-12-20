<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\TransaksiStok;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiStok::with(['bahan', 'pengguna']);

        // Filter berdasarkan jenis transaksi
        if ($request->filled('jenis_transaksi')) {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        // Filter berdasarkan pegawai
        if ($request->filled('id_pengguna')) {
            $query->where('id_pengguna', $request->id_pengguna);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $transaksis = $query->latest('tanggal')->paginate(20);
        $penggunas = Pengguna::where('role', 'pegawai')->get();

        return view('pegawai.laporan.index', compact('transaksis', 'penggunas'));
    }
}