<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BahanController extends Controller
{
    // Daftar satuan yang diizinkan (standar)
    private array $allowedUnits = ['kg','g','mg','liter','ml','pcs','pack','box','meter','cm','mm','lusin','rim'];

    public function index()
    {
        $bahans = Bahan::all();
        return view('admin.bahan.index', compact('bahans'));
    }

    public function create()
    {
        // Kirim daftar satuan ke view agar dropdown
        $units = $this->allowedUnits;
        return view('admin.bahan.create', compact('units'));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $validator = Validator::make($request->all(), [
            'nama_bahan' => 'required|unique:bahan,nama_bahan',
            'satuan' => 'required|string',
            'satuan_lainnya' => 'nullable|string',
            'stok_minimum' => 'required|integer|min:0',
        ], [
            'nama_bahan.unique' => 'Nama bahan sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Normalisasi satuan
        $satuan = strtolower($request->input('satuan'));

        if ($satuan === 'lainnya') {
            $custom = trim($request->input('satuan_lainnya', ''));
            if ($custom === '') {
                return back()->withErrors(['satuan_lainnya' => 'Satuan kustom wajib diisi.'])->withInput();
            }
            $satuan = $custom;
        } else {
            if (!in_array($satuan, $this->allowedUnits, true)) {
                return back()->withErrors(['satuan' => 'Satuan tidak valid.'])->withInput();
            }
        }

        Bahan::create([
            'nama_bahan' => $request->input('nama_bahan'),
            'satuan' => $satuan,
            'stok_minimum' => (int) $request->input('stok_minimum'),
        ]);

        return redirect()->route('admin.bahan.index')->with('success', 'Data bahan berhasil ditambahkan.');
    }

    public function edit(Bahan $bahan)
    {
        // Kirim daftar satuan dan info apakah satuan saat ini ada di daftar
        $units = $this->allowedUnits;
        $inList = in_array(strtolower($bahan->satuan), $units, true);
        return view('admin.bahan.edit', compact('bahan', 'units', 'inList'));
    }

    public function update(Request $request, Bahan $bahan)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahan' => 'required|unique:bahan,nama_bahan,' . $bahan->id_bahan . ',id_bahan',
            'satuan' => 'required|string',
            'satuan_lainnya' => 'nullable|string',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Normalisasi satuan
        $satuan = strtolower($request->input('satuan'));

        if ($satuan === 'lainnya') {
            $custom = trim($request->input('satuan_lainnya', ''));
            if ($custom === '') {
                return back()->withErrors(['satuan_lainnya' => 'Satuan kustom wajib diisi.'])->withInput();
            }
            $satuan = $custom;
        } else {
            if (!in_array($satuan, $this->allowedUnits, true)) {
                return back()->withErrors(['satuan' => 'Satuan tidak valid.'])->withInput();
            }
        }

        $bahan->update([
            'nama_bahan' => $request->input('nama_bahan'),
            'satuan' => $satuan,
            'stok_minimum' => (int) $request->input('stok_minimum'),
        ]);

        return redirect()->route('admin.bahan.index')->with('success', 'Data bahan berhasil diperbarui.');
    }

    public function destroy(Bahan $bahan)
    {
        if ($bahan->transaksiStok()->exists()) {
            return back()->withErrors(['error' => "Data '{$bahan->nama_bahan}' tidak dapat dihapus karena sudah memiliki riwayat transaksi."]);
        }

        $bahan->delete();
        return redirect()->route('admin.bahan.index')->with('success', 'Data bahan berhasil dihapus.');
    }
}