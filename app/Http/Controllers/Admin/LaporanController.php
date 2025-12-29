<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanStok;
use App\Models\Pengguna;
use App\Exports\LaporanStokExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanStok::with(['bahan', 'pengguna']);

        // Filter berdasarkan jenis transaksi
        if ($request->filled('jenis_transaksi')) {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        // Filter berdasarkan pegawai
        if ($request->filled('id_pengguna')) {
            $query->where('id_pengguna', $request->id_pengguna);
        }

        // Filter berdasarkan tanggal (untuk tampilan)
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $transaksis = $query->latest('tanggal')->paginate(20);
        $penggunas = Pengguna::where('role', 'pegawai')->get();

        return view('admin.laporan.index', compact('transaksis', 'penggunas'));
    }

    public function exportExcel(Request $request)
    {
        $query = LaporanStok::with(['bahan', 'pengguna']);

        // Filter berdasarkan jenis transaksi
        if ($request->filled('jenis_transaksi')) {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        // Filter berdasarkan pegawai
        if ($request->filled('id_pengguna')) {
            $query->where('id_pengguna', $request->id_pengguna);
        }

        // Filter khusus export: bulan lebih prioritas, fallback ke rentang tanggal
        if ($request->filled('bulan')) {
            $start = Carbon::parse($request->bulan . '-01')->startOfMonth();
            $end = (clone $start)->endOfMonth();
            $query->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()]);
        } else {
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
            }
        }

        $transaksis = $query->latest('tanggal')->get();

        // Generate filename
        $filename = 'Laporan_Stok_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';

        // Export menggunakan Laravel Excel
        return Excel::download(new LaporanStokExport($transaksis, 'Laporan Stok'), $filename);
    }

    public function exportMasuk(Request $request)
    {
        $query = LaporanStok::with(['bahan', 'pengguna'])->where('jenis_transaksi', 'masuk');

        // Filter berdasarkan pegawai
        if ($request->filled('id_pengguna')) {
            $query->where('id_pengguna', $request->id_pengguna);
        }

        if ($request->filled('bulan')) {
            $start = Carbon::parse($request->bulan . '-01')->startOfMonth();
            $end = (clone $start)->endOfMonth();
            $query->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()]);
        } else {
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
            }
        }

        $transaksis = $query->latest('tanggal')->get();
        $filename = 'Laporan_Stok_Masuk_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new LaporanStokExport($transaksis, 'Stok Masuk'), $filename);
    }

    public function exportKeluar(Request $request)
    {
        $query = LaporanStok::with(['bahan', 'pengguna'])->where('jenis_transaksi', 'keluar');

        // Filter berdasarkan pegawai
        if ($request->filled('id_pengguna')) {
            $query->where('id_pengguna', $request->id_pengguna);
        }

        if ($request->filled('bulan')) {
            $start = Carbon::parse($request->bulan . '-01')->startOfMonth();
            $end = (clone $start)->endOfMonth();
            $query->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()]);
        } else {
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
            }
        }

        $transaksis = $query->latest('tanggal')->get();
        $filename = 'Laporan_Stok_Keluar_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new LaporanStokExport($transaksis, 'Stok Keluar'), $filename);
    }
}