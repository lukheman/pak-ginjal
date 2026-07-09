<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKonsultasi;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasienDashboardController extends Controller
{
    /**
     * Tampilkan riwayat diagnosis milik pasien
     */
    public function riwayat()
    {
        $pasienId = auth('pasien')->id();
        $riwayats = RiwayatKonsultasi::where('pasien_id', $pasienId)->latest()->get();
        
        return view('pasien_dashboard.riwayat', compact('riwayats'));
    }

    /**
     * Tampilkan form profil pasien
     */
    public function profile()
    {
        $pasien = auth('pasien')->user();
        return view('pasien_dashboard.profile', compact('pasien'));
    }

    /**
     * Update profil pasien
     */
    public function updateProfile(Request $request)
    {
        $pasien = auth('pasien')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pasien,email,' . $pasien->id,
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // update the user directly
        $pasien->update($data);

        return redirect()->route('pasien.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
