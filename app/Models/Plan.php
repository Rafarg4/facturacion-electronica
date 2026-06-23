<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'planes';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'empresa',
        'descripcion',
        'fecha_inicio',
        'cantidad_cuotas',
        'monto_cuota',
        'periodicidad',
        'monto_total',
        'estado',
        'observacion',
    ];

    protected $casts = [
        'fecha_inicio'    => 'date',
        'monto_cuota'     => 'decimal:2',
        'monto_total'     => 'decimal:2',
        'cantidad_cuotas' => 'integer',
    ];

    public static $rules = [
        'empresa'         => 'required|string',
        'descripcion'     => 'nullable|string',
        'fecha_inicio'    => 'required|date',
        'cantidad_cuotas' => 'required|integer|min:1|max:360',
        'monto_cuota'     => 'required|numeric|min:0.01',
        'periodicidad'    => 'required|in:mensual,quincenal,semanal',
        'estado'          => 'required|string',
        'observacion'     => 'nullable|string',
    ];

    public function cuotas()
    {
        return $this->hasMany(MiPlan::class, 'plan_id')->orderBy('nro_cuota');
    }
}
