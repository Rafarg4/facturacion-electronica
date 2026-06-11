<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Rubro
 * @package App\Models
 * @version June 8, 2026, 10:16 am -04
 *
 * @property string $descripcion
 * @property string $estado
 */
class Rubro extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'rubros';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'descripcion',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'descripcion' => 'string',
        'estado' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'descripcion' => 'required',
        'estado' => 'required'
    ];

    
}
