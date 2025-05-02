<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alamat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlamatController extends Controller
{
    // Ambil semua alamat user
    public function index()
    {
        $user = Auth::user();
        $alamat = $user->alamat()->get();

        return response()->json(['alamat' => $alamat]);
    }

    // Tambah alamat baru
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'utama' => 'boolean',
        ]);

        // Jika alamat ini dijadikan utama, reset lainnya
        if ($request->utama) {
            $user->alamat()->update(['utama' => 0]);
        }

        $alamat = $user->alamat()->create([
            'nama' => $validated['nama'],
            'no_whatsapp' => $validated['no_whatsapp'],
            'alamat' => $validated['alamat'],
            'utama' => $request->boolean('utama'),
        ]);

        return response()->json(['success' => true, 'alamat' => $alamat]);
    }

    // Update alamat
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'utama' => 'boolean',
        ]);

        $alamat = $user->alamat()->where('id_alamat', $id)->firstOrFail();

        if ($request->utama) {
            $user->alamat()->update(['utama' => 0]);
        }

        $alamat->update([
            'nama' => $validated['nama'],
            'no_whatsapp' => $validated['no_whatsapp'],
            'alamat' => $validated['alamat'],
            'utama' => $request->boolean('utama'),
        ]);

        return response()->json(['success' => true, 'alamat' => $alamat]);
    }

    // Hapus alamat
    public function destroy($id)
    {
        $user = Auth::user();

        $alamat = $user->alamat()->where('id_alamat', $id)->firstOrFail();
        $alamat->delete();

        return response()->json(['success' => true, 'message' => 'Alamat dihapus']);
    }

    // Set alamat utama
    public function setPrimary($id)
    {
        $user = Auth::user();

        $user->alamat()->update(['utama' => 0]);

        $user->alamat()->where('id_alamat', $id)->update(['utama' => 1]);

        return response()->json(['success' => true, 'message' => 'Alamat utama diperbarui']);
    }
}
