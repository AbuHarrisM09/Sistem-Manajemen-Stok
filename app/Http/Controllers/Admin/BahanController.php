<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BahanController extends Controller
{
    public function index()
    {
        $bahans = Bahan::all();
        return view('admin.bahan.index', compact('bahans'));
    }

    public function create()
    {
        return view('admin.bahan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahan' => 'required|unique:bahan,nama_bahan',
            'satuan' => 'required',
            'stok_minimum' => 'required|integer|min:0',
        ], [
            'nama_bahan.unique' => 'Nama bahan sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Bahan::create($request->only('nama_bahan', 'satuan', 'stok_minimum'));
        return redirect()->route('admin.bahan.index')->with('success', 'Data bahan berhasil ditambahkan.');
    }

    public function edit(Bahan $bahan)
    {
        return view('admin.bahan.edit', compact('bahan'));
    }

    public function update(Request $request, Bahan $bahan)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahan' => 'required|unique:bahan,nama_bahan,' . $bahan->id_bahan . ',id_bahan',
            'satuan' => 'required',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $bahan->update($request->only('nama_bahan', 'satuan', 'stok_minimum'));
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