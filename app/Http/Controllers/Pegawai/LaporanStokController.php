<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\LaporanStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class LaporanStokController extends Controller
{
    public function indexMasuk()
    {
        return $this->indexStokMasuk();
    }

    public function storeMasuk(Request $request)
    {
        return $this->catatStokMasuk($request);
    }

    public function indexKeluar()
    {
        return $this->indexStokKeluar();
    }

    public function storeKeluar(Request $request)
    {
        return $this->catatStokKeluar($request);
    }
    public function indexStokMasuk()
    {
        $bahans = Bahan::all();

        $transaksis = LaporanStok::with(['bahan', 'pengguna'])
            ->where('jenis_transaksi', 'masuk')
            ->latest('tanggal')
            ->paginate(10);

        return view('pegawai.transaksi.masuk', compact('bahans', 'transaksis'));
    }

    public function indexStokKeluar()
    {
        $bahans = Bahan::all();

        $transaksis = LaporanStok::with(['bahan', 'pengguna'])
            ->where('jenis_transaksi', 'keluar')
            ->latest('tanggal')
            ->paginate(10);

        return view('pegawai.transaksi.keluar', compact('bahans', 'transaksis'));
    }

    public function catatStokMasuk(Request $request)
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

        LaporanStok::create([
            'id_bahan' => $request->id_bahan,
            'id_pengguna' => auth('pengguna')->id(),
            'tanggal' => $request->tanggal,
            'jumlah_bahan' => $request->jumlah_bahan,
            'jenis_transaksi' => 'masuk',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transaksi.masuk')->with('success', 'Transaksi stok masuk berhasil dicatat.');
    }

    public function catatStokKeluar(Request $request)
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

        LaporanStok::create([
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
