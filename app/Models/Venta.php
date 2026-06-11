<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Venta
 * @package App\Models
 * @version May 1, 2025, 6:11 pm -04
 *
 * @property string $id_cliente
 * @property string $fecha_venta
 * @property string $id_usuario
 * @property string $tipo_comprobante
 * @property string $numero_comprobante
 * @property string $total
 * @property string $iva
 * @property string $forma_pago
 * @property string $estado
 * @property string $observacion
 */
class Venta extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'ventas';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id_cliente',
        'fecha_venta',
        'id_usuario',
        'tipo_comprobante',
        'numero_comprobante',
        'total',
        'iva',
        'condicion_venta',
        'forma_pago',
        'estado',
        'observacion',
        'id_caja'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_cliente' => 'string',
        'fecha_venta' => 'string',
        'id_usuario' => 'string',
        'tipo_comprobante' => 'string',
        'numero_comprobante' => 'string',
        'total' => 'string',
        'iva' => 'string',
        'forma_pago' => 'string',
        'estado' => 'string',
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
