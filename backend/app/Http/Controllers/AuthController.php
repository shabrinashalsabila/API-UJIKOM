<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use App\Models\User;
=======
>>>>>>> 910a5db3b8915f0e8467a9af53a060db3e0fe71e

class AuthController extends Controller
{
    // Menampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

<<<<<<< HEAD
            // Redirect berdasarkan Role
=======
            // Redirect berdasarkan Role sesuai matriks Anda
>>>>>>> 910a5db3b8915f0e8467a9af53a060db3e0fe71e
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'petugas') {
                return redirect()->route('petugas.peminjaman.index');
            } elseif ($user->role === 'peminjam') {
                return redirect()->route('peminjam.katalog');
            }

            Auth::logout();
<<<<<<< HEAD

            return redirect()->route('login')
                ->with('error', 'Role tidak dikenali.');
=======
            return redirect()->route('login')->with('error', 'Role tidak dikenali.');
>>>>>>> 910a5db3b8915f0e8467a9af53a060db3e0fe71e
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

<<<<<<< HEAD
    // Menampilkan Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Memproses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'no_hp' => ['required', 'numeric', 'digits_between:10,13'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between' => 'Nomor HP harus 10 sampai 13 digit.',
        ]);

        // Membuat akun baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'peminjam',
        ]);

        // Arahkan ke halaman login setelah registrasi berhasil
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login akun kamu.');
    }

=======
>>>>>>> 910a5db3b8915f0e8467a9af53a060db3e0fe71e
    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
<<<<<<< HEAD

=======
>>>>>>> 910a5db3b8915f0e8467a9af53a060db3e0fe71e
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
