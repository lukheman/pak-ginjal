<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\RiwayatKonsultasi;
use App\Services\CertaintyFactorService;
use App\Services\DempsterShaferService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KonsultasiController extends Controller
{
    /**
     * Tampilkan form diagnosa ke user
     */
    public function index()
    {
        $gejala = Gejala::orderBy('kode', 'asc')->get();
        return view('konsultasi.index', compact('gejala'));
    }

    /**
     * Proses hitung diagnosa dan simpan ke database
     */
    public function proses(Request $request)
    {
        $request->validate([
            'gejala' => 'required|array|min:1',
        ]);

        // Filter array gejala: Hapus yang isinya null/0
        $inputGejala = array_filter($request->gejala, function($val) {
            return $val !== null && floatval($val) > 0;
        });

        if (empty($inputGejala)) {
            return back()->with('error', 'Anda harus memilih setidaknya satu gejala yang dialami!');
        }

        // 1. Hitung dengan metode Certainty Factor (CF)
        $cfResult = CertaintyFactorService::diagnosis($inputGejala);

        // 2. Hitung dengan metode Dempster-Shafer (DS)
        $dsResult = DempsterShaferService::diagnosis($inputGejala);

        $user = auth('pasien')->user();

        // Simpan riwayat konsultasi
        $riwayat = RiwayatKonsultasi::create([
            'pasien_id' => $user->id,
            'nama_pasien' => $user->nama,
            'tanggal_lahir' => $user->tanggal_lahir,
            'tempat_lahir' => $user->tempat_lahir,
            'hasil_penyakit_cf_id' => $cfResult['id'],
            'nilai_cf' => $cfResult['cf'],
            
            // Kolom Dempster-Shafer
            'hasil_penyakit_ds_id' => $dsResult['id'],
            'nilai_ds' => $dsResult['ds'],
            
            // Detail input gejala JSON
            'input_gejala' => json_encode($inputGejala),
        ]);
        
        $riwayat->save();

        return redirect()->route('konsultasi.hasil', $riwayat->id);
    }

    /**
     * Tampilkan hasil diagnosa
     */
    public function hasil($id)
    {
        $riwayat = RiwayatKonsultasi::findOrFail($id);
        $gejalaUser = json_decode($riwayat->input_gejala, true);
        
        $gejalaList = Gejala::whereIn('id', array_keys($gejalaUser))->get();
        $penyakitCf = Penyakit::find($riwayat->hasil_penyakit_cf_id);
        $penyakitDs = Penyakit::find($riwayat->hasil_penyakit_ds_id);

        return view('konsultasi.hasil', compact('riwayat', 'gejalaUser', 'gejalaList', 'penyakitCf', 'penyakitDs'));
    }

    /**
     * Cetak hasil diagnosa ke PDF
     */
    public function cetak($id)
    {
        $riwayat = RiwayatKonsultasi::findOrFail($id);
        $gejalaUser = json_decode($riwayat->input_gejala, true);
        
        $gejalaList = Gejala::whereIn('id', array_keys($gejalaUser))->get();
        $penyakitCf = Penyakit::find($riwayat->hasil_penyakit_cf_id);
        $penyakitDs = Penyakit::find($riwayat->hasil_penyakit_ds_id);

        $pdf = Pdf::loadView('konsultasi.pdf', compact('riwayat', 'gejalaUser', 'gejalaList', 'penyakitCf', 'penyakitDs'));
        return $pdf->download('Hasil_Diagnosis_' . $riwayat->nama_pasien . '.pdf');
    }
}
