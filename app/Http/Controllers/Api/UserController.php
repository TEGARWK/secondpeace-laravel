<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // ✅ tambahkan ini

class UserController extends Controller
{
    public function update(Request $request)
{
    $user = User::find(Auth::id()); // ✅ casting ke model User

    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    $user->nama = $request->nama;
    $user->email = $request->email;

    if ($request->hasFile('foto_profil')) {
        $path = $request->file('foto_profil')->store('public/foto_profil');
        $user->foto_profil = basename($path);
    }

    $user->save(); // ✅ sekarang ini valid

    return response()->json([
        'success' => true,
        'message' => 'Profil berhasil diperbarui',
        'user' => $user,
    ]);
}

}
