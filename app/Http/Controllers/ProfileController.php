<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::guard('pengguna')->user();

        return view('profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('pengguna')->user();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'nama' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::min(6)],
        ]);

        $user->username = $validated['username'];
        $user->nama = $validated['nama'] ?? null;

        if (!empty($validated['password'])) {
            // Model Pengguna punya mutator untuk hashing
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('profil.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
