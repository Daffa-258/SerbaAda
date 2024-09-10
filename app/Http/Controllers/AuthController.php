<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Cek kredensial user
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();

            // Cek apakah user adalah admin
            if ($user->isAdmin) {
                return redirect('/admin/users/')->with('login_admin','login succesfully');
            }

            // Jika bukan admin, arahkan ke halaman utama
            return redirect('/home')->with('login_user','login succesfully');

        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Method untuk logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

