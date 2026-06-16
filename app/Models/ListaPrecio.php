<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ListaPrecio
 * @package App\Models
 * @version June 16, 2026, 9:35 am -04
 *
 * @property string $descripcion
 * @property string $porcentaje
 * @property string $estado
 */
class ListaPrecio extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'lista_precios';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'descripcion',
        'porcentaje',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'descripcion' => 'string',
        'porcentaje' => 'string',
        'estado' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'descripcion' => 'required',
        'porcentaje' => 'required',
        'estado' => 'required'
    ];

    
}
