<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Empresa
 * @package App\Models
 * @version May 7, 2025, 9:50 pm -04
 *
 * @property string $nombre
 * @property string $ruc
 * @property string $descripcion
 * @property string $logo
 */
class Empresa extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'empresas';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'ruc',
        'descripcion',
        'logo',
        'fecha_habilitacion',
        'timbrado',
        'direccion',
        'telefono',
        'correo',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'ruc' => 'string',
        'descripcion' => 'string',
        'logo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required',
        'ruc' => 'required',
        'descripcion' => 'required',
        'logo' => 'required'
    ];

    
}
