<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasienAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.pasien_register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pasien',
            'password' => 'required|string|min:6|confirmed',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
        ]);

        $pasien = Pasien::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silakan masuk menggunakan email dan kata sandi Anda.');
    }
}
