<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Caja
 * @package App\Models
 * @version May 7, 2025, 9:36 pm -04
 *
 * @property string $nombre
 * @property string $descripcion
 */
class Caja extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'cajas';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'descripcion',
        'apertura',
        'cierre',
        'fecha'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'descripcion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
       
    ];

    
}
