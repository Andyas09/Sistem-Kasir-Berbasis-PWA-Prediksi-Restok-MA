<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function profil()
    {
        return view('pengguna.profil');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil Logout');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'status' => 'Aktif',
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            if (auth()->user()->role_id == 1) {
                return redirect()->route('dashboard.index')->with('success', 'Selamat !! Anda berhasil Login');
            }

            if (auth()->user()->role_id == 2) {
                return redirect()->route('pos.transaksi')->with('success', 'Selamat !! Anda berhasil Login');
            }

            Auth::logout();
            abort(403, 'Role tidak dikenali');
        }

        return back()->with('error', 'Gagal Login');
    }

    public function showLogin()
    {
        return view('auth.login');
    }
}
