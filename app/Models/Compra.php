<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Compra
 * @package App\Models
 * @version May 11, 2025, 7:42 pm -04
 *
 * @property string $id_proveedor
 * @property string $fecha_compra
 * @property string $tipo_comprobante
 * @property string $numero_comprobante
 * @property string $total
 * @property string $iva
 * @property string $forma_pago
 * @property string $condicion_compra
 * @property string $estado
 * @property string $id_caja
 * @property string $observacion
 */
class Compra extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'compras';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id_pedido',
        'fecha_compra',
        'tipo_comprobante',
        'numero_comprobante',
        'total',
        'id_pedido',
        'iva',
        'forma_pago',
        'condicion_compra',
        'estado',
        'id_caja',
        'observacion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_proveedor' => 'string',
        'fecha_compra' => 'string',
        'tipo_comprobante' => 'string',
        'numero_comprobante' => 'string',
        'total' => 'string',
        'iva' => 'string',
        'forma_pago' => 'string',
        'condicion_compra' => 'string',
        'estado' => 'string',
        'id_caja' => 'string',
        'observacion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    public function Pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
    
}
