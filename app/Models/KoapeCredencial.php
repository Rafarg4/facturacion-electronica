<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoapeCredencial extends Model
{
    public $table = 'koape_credenciales';

    protected $fillable = [
        'usuario',
        'password',
        'codigo_acceso',
        'base_url',
        'establecimiento',
        'punto_expedicion',
    ];

    protected $casts = [
        'password' => 'encrypted',
        'codigo_acceso' => 'encrypted',
    ];
}
