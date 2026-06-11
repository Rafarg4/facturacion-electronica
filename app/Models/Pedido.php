<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Pedido
 * @package App\Models
 * @version May 14, 2025, 11:00 am -04
 *
 * @property string $id_proveedor
 * @property string $fecha
 * @property string $total
 * @property string $estado
 */
class Pedido extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'pedidos';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id_proveedor',
        'fecha',
        'total',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_proveedor' => 'string',
        'fecha' => 'string',
        'total' => 'string',
        'estado' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    
}
