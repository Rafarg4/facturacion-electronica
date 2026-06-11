<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Cobro
 * @package App\Models
 * @version May 2, 2025, 7:52 pm -04
 *
 * @property string $id_cliente
 * @property string $id_venta
 * @property string $fecha_cobro
 * @property string $cajero
 * @property string $observacion
 */
class Cobro extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'cobros';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id_cliente',
        'id_venta',
        'fecha_cobro',
        'cajero',
        'total',
        'id_caja',
        'monto',
        'estado',
        'observacion',
        'numero_comprobante',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_cliente' => 'string',
        'id_venta' => 'string',
        'fecha_cobro' => 'string',
        'cajero' => 'string',
        'observacion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
