<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Pasien;
use App\Models\Penyakit;
use App\Models\RiwayatKonsultasi;
use Illuminate\Http\Request;

class AdminRiwayatController extends Controller
{
    /**
     * Tampilkan semua riwayat diagnosis untuk satu pasien tertentu
     */
    public function index($id)
    {
        $pasien = Pasien::findOrFail($id);
        $riwayats = RiwayatKonsultasi::where('pasien_id', $pasien->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.riwayat.index', compact('pasien', 'riwayats'));
    }

    /**
     * Tampilkan detail riwayat diagnosis
     */
    public function show($id)
    {
        $riwayat = RiwayatKonsultasi::findOrFail($id);
        $gejalaUser = json_decode($riwayat->input_gejala, true);
        
        $gejalaList = Gejala::whereIn('id', array_keys($gejalaUser))->get();
        $penyakitCf = Penyakit::find($riwayat->hasil_penyakit_cf_id);
        $penyakitDs = Penyakit::find($riwayat->hasil_penyakit_ds_id);

        return view('admin.riwayat.show', compact('riwayat', 'gejalaUser', 'gejalaList', 'penyakitCf', 'penyakitDs'));
    }
}
