<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'solusi',
        'photo',
    ];

    public function basisPengetahuans()
    {
        return $this->hasMany(BasisPengetahuan::class, 'penyakit_id');
    }

    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'basis_pengetahuans', 'penyakit_id', 'gejala_id')
                    ->withPivot('mb', 'md', 'id')
                    ->withTimestamps();
    }
}
