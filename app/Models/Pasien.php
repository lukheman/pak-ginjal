<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pasien extends Authenticatable
{
    use Notifiable;

    protected $table = 'pasien';

    protected $fillable = [
        'nama',
        'email',
        'password',
        
        'tanggal_lahir',
        'tempat_lahir',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
