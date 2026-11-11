<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Request\LoginController;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan Form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Memproses R
    public function register(Request $request)
    {
        $request->validate([
            'name' =>'required|max:100|name',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|password',
        ]);

        $user = user::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>hash::make('$request->password'),
            'role' => 'peminjam',
        ]);
        
        Auth::login();
            return redirect()->route('peminjam.katalog')->with('success', 'Register Berhasil.');
        }

         // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}