<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiStok;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        return view('admin.laporan.index', compact('transaksis', 'penggunas'));
    }

    public function exportExcel(Request $request)
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

        $transaksis = $query->latest('tanggal')->get();

        // Generate filename
        $filename = 'Laporan_Stok_' . Carbon::now()->format('Y-m-d_His') . '.csv';

        // Set headers for CSV download
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        // Create callback function for streaming
        $callback = function() use ($transaksis) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($file, [
                'No',
                'Tanggal',
                'Nama Bahan',
                'Jenis Transaksi',
                'Jumlah',
                'Satuan',
                'Pegawai',
                'Keterangan'
            ]);

            // Data rows
            $no = 1;
            foreach ($transaksis as $transaksi) {
                fputcsv($file, [
                    $no++,
                    Carbon::parse($transaksi->tanggal)->format('d-m-Y'),
                    $transaksi->bahan->nama_bahan ?? '-',
                    ucfirst($transaksi->jenis_transaksi),
                    $transaksi->jumlah_bahan,
                    $transaksi->bahan->satuan ?? '-',
                    $transaksi->pengguna->nama ?? '-',
                    $transaksi->keterangan ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportMasuk(Request $request)
    {
        $request->merge(['jenis_transaksi' => 'masuk']);
        return $this->exportExcel($request);
    }

    public function exportKeluar(Request $request)
    {
        $request->merge(['jenis_transaksi' => 'keluar']);
        return $this->exportExcel($request);
    }
}