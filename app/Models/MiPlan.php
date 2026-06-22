<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MiPlan
 * @package App\Models
 * @version June 21, 2026, 3:32 pm -04
 *
 * @property string $empresa
 * @property string $nro_cuota
 * @property string $fecha_vencimiento
 * @property string $fecha_pago
 * @property string $monto_cuota
 * @property string $saldo_cuota
 * @property string $estado
 * @property string $observacion
 */
class MiPlan extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'mi_plans';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'empresa',
        'nro_cuota',
        'fecha_vencimiento',
        'fecha_pago',
        'monto_cuota',
        'saldo_cuota',
        'estado',
        'observacion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'empresa' => 'string',
        'nro_cuota' => 'string',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date:Y-m-d',
        'monto_cuota' => 'string',
        'saldo_cuota' => 'string',
        'estado' => 'string',
        'observacion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'empresa' => 'required',
        'nro_cuota' => 'required',
        'fecha_vencimiento' => 'required',
        'fecha_pago' => 'nullable',
        'monto_cuota' => 'required',
        'saldo_cuota' => 'required',
        'estado' => 'required',
        'observacion' => 'nullable'
    ];

    
}
