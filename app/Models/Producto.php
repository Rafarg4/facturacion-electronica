<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Producto
 * @package App\Models
 * @version May 1, 2025, 2:31 pm -04
 *
 * @property string $nombre
 * @property string $descripcion
 * @property string $id_categoria
 * @property string $cantidad
 * @property string $cantidad_minima
 * @property string $precio_venta
 * @property string $precio_compra
 * @property string $estado
 * @property string $id_proveedor
 */
class Producto extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'productos';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'descripcion',
        'id_categoria',
        'cantidad',
        'cantidad_minima',
        'precio_venta',
        'precio_compra',
        'estado',
        'id_rubro',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'descripcion' => 'string',
        'id_categoria' => 'string',
        'cantidad' => 'string',
        'cantidad_minima' => 'string',
        'precio_venta' => 'string',
        'precio_compra' => 'string',
        'estado' => 'string',
        'id_proveedor' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
       
    ];

    
}
