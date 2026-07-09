<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKonsultasi extends Model
{
    protected $table = 'riwayat_konsultasi';

    protected $fillable = [
        'pasien_id',
        'nama_pasien',
        'tanggal_lahir',
        'tempat_lahir',
        'input_gejala',
        'hasil_penyakit_cf_id',
        'nilai_cf',
        'hasil_penyakit_ds_id',
        'nilai_ds',
    ];
}
