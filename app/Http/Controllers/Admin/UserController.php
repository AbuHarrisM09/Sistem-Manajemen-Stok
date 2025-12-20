<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // List pegawai
    public function index()
    {
        $pegawais = Pengguna::where('role', 'pegawai')->orderBy('username')->get();
        return view('admin.pegawai.index', compact('pegawais'));
    }

    // Form create
    public function create()
    {
        return view('admin.pegawai.create');
    }

    // Simpan pegawai baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', 'unique:pengguna,username'],
            'nama' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        Pengguna::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => 'pegawai',
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai baru berhasil dibuat.');
    }

    // Form edit
    public function edit(Pengguna $pengguna)
    {
        abort_unless($pengguna->role === 'pegawai', 404);
        return view('admin.pegawai.edit', compact('pengguna'));
    }

    // Update pegawai
    public function update(Request $request, Pengguna $pengguna)
    {
        abort_unless($pengguna->role === 'pegawai', 404);

        $validated = $request->validate([
            'username' => [
                'required', 'string', 'min:3', 'max:50', 'alpha_dash',
                Rule::unique('pengguna', 'username')->ignore($pengguna->id_pengguna, 'id_pengguna'),
            ],
            'nama' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $data = [
            'username' => $validated['username'],
            'nama' => $validated['nama'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $pengguna->update($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    // Hapus pegawai
    public function destroy(Pengguna $pengguna)
    {
        abort_unless($pengguna->role === 'pegawai', 404);
        $pengguna->delete();

        return back()->with('success', 'Pegawai berhasil dihapus.');
    }
}