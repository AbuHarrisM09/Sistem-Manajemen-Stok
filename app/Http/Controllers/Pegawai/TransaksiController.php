<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\TransaksiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function indexMasuk()
    {
        $bahans = Bahan::all();
        
        // Ambil riwayat transaksi masuk
        $transaksis = TransaksiStok::with(['bahan', 'pengguna'])
            ->where('jenis_transaksi', 'masuk')
            ->latest('tanggal')
            ->paginate(10);
            
        return view('pegawai.transaksi.masuk', compact('bahans', 'transaksis'));
    }

    public function storeMasuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_bahan' => 'required|exists:bahan,id_bahan',
            'jumlah_bahan' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        TransaksiStok::create([
            'id_bahan' => $request->id_bahan,
            'id_pengguna' => auth('pengguna')->id(),
            'tanggal' => $request->tanggal,
            'jumlah_bahan' => $request->jumlah_bahan,
            'jenis_transaksi' => 'masuk',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transaksi.masuk')->with('success', 'Transaksi stok masuk berhasil dicatat.');
    }

    public function indexKeluar()
    {
        $bahans = Bahan::all();
        
        // Ambil riwayat transaksi keluar
        $transaksis = TransaksiStok::with(['bahan', 'pengguna'])
            ->where('jenis_transaksi', 'keluar')
            ->latest('tanggal')
            ->paginate(10);
            
        return view('pegawai.transaksi.keluar', compact('bahans', 'transaksis'));
    }

    public function storeKeluar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_bahan' => 'required|exists:bahan,id_bahan',
            'jumlah_bahan' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $bahan = Bahan::findOrFail($request->id_bahan);
        $stokTersedia = $bahan->stok_saat_ini;

        if ($request->jumlah_bahan > $stokTersedia) {
            return back()->withErrors([
                'jumlah_bahan' => "Stok tidak mencukupi. Stok tersedia: {$stokTersedia} {$bahan->satuan}."
            ])->withInput();
        }

        TransaksiStok::create([
            'id_bahan' => $request->id_bahan,
            'id_pengguna' => auth('pengguna')->id(),
            'tanggal' => $request->tanggal,
            'jumlah_bahan' => $request->jumlah_bahan,
            'jenis_transaksi' => 'keluar',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transaksi.keluar')->with('success', 'Transaksi stok keluar berhasil dicatat.');
    }
}