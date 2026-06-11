<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Proveedor
 * @package App\Models
 * @version May 1, 2025, 2:15 pm -04
 *
 * @property string $nombre
 * @property string $apellido
 * @property string $ci
 * @property string $correo
 * @property string $direccion
 * @property string $telefono
 * @property string $compania
 */
class Proveedor extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'proveedors';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'apellido',
        'ci',
        'correo',
        'direccion',
        'telefono',
        'compania'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'apellido' => 'string',
        'ci' => 'string',
        'correo' => 'string',
        'direccion' => 'string',
        'telefono' => 'string',
        'compania' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required',
        'apellido' => 'required',
        'ci' => 'required',
        'correo' => 'required',
        'direccion' => 'required',
        'telefono' => 'required',
        'compania' => 'required'
    ];

    
}
