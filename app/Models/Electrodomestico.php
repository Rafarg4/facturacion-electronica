<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Electrodomestico
 * @package App\Models
 * @version September 23, 2024, 7:52 pm -04
 *
 * @property string $nombre
 * @property string $marca
 * @property string $precio
 */
class Electrodomestico extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'electrodomesticos';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'marca',
        'precio_venta',
        'precio_compra'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'marca' => 'string',
        'precio' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
