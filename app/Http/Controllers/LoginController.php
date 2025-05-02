<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // Tampilkan form login admin
    public function showLoginFormAdmin()
    {
        return view('login-admin');
    }

    // Tampilkan form login pelanggan
    public function showLoginFormPelanggan()
    {
        return view('login-pelanggan');
    }

    // Proses login admin
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
                    ->where('role', 'admin')
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Login admin berhasil!');
        }

        return back()->withErrors(['login_error' => 'Username atau password salah, atau bukan admin.']);
    }

    public function loginPelanggan(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'pelanggan')
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard.pelanggan')->with('success', 'Login pelanggan berhasil!');
        }

        return back()->withErrors(['login_error' => 'Email atau password salah!']);
    }

    // Logout umum
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
