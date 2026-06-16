<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PresupuestoCabecera
 * @package App\Models
 * @version June 14, 2026, 12:32 pm -04
 *
 * @property string $cliente
 * @property string $estado
 * @property string $responsable
 * @property string $descripcion
 * @property string $sub_total
 * @property string $total
 * @property string $tipo_presupuesto
 */
class PresupuestoCabecera extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'presupuesto_cabeceras';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id_cliente',
        'tipo_moneda',
        'estado',
        'responsable',
        'descripcion',
        'sub_total',
        'total',
        'total_gs',
        'tipo_presupuesto',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cliente' => 'string',
        'estado' => 'string',
        'responsable' => 'string',
        'descripcion' => 'string',
        'sub_total' => 'string',
        'total' => 'string',
        'tipo_moneda' => 'string',
        'tipo_presupuesto' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
