<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Cotizacion
 * @package App\Models
 * @version May 29, 2026, 8:14 pm -04
 *
 * @property string $tipo_moneda
 * @property string $compra
 * @property string $venta
 */
class Cotizacion extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'cotizacions';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'tipo_moneda',
        'compra',
        'venta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tipo_moneda' => 'string',
        'compra' => 'string',
        'venta' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tipo_moneda' => 'required',
        'compra' => 'required',
        'venta' => 'required'
    ];

    
}
