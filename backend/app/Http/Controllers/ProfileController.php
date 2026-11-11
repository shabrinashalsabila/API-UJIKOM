<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function edit()
    {
        $user = auth()->user();

        return view('profile.edit', compact('user'));
    }

    // Memperbarui data profil
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'no_hp' => 'nullable|string|max:20',

            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'foto_profile.image' => 'File harus berupa gambar.',
            'foto_profile.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto_profile.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Memperbarui data pengguna
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;

        // Mengunggah foto profil baru
        if ($request->hasFile('foto_profile')) {

            // Menghapus foto lama
            if ($user->foto_profile) {
                Storage::disk('public')->delete($user->foto_profile);
            }

            // Menyimpan foto baru
            $user->foto_profile = $request->file('foto_profile')
                ->store('foto-profil', 'public');
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}