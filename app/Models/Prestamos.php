<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prestamos extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'prestamos';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id_cliente',
        'monto',
        'fecha_inicio',
        'fecha_pago',
        'cantidad_cuota',
        'tipo_prestamo',
        'id_electrodomestico',
        'zona',
        'monto_cuota',
        'id_electrodomestico',
        'numero_prestamo',
        'frecuencia_pago' // Asegura que este campo es asignable
    ];

    protected $casts = [
        'id_cliente' => 'string',
        'monto' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_pago' => 'date',
        'cantidad_cuota' => 'integer',
        'tipo_prestamo' => 'string',
        'id_electrodomestico' => 'integer',
        'zona' => 'string',
        'monto_cuota' => 'decimal:2',
        'numero_prestamo' => 'integer',
        'frecuencia_pago' => 'string' // Definimos el tipo de dato
    ];

    public static $rules = [
        'id_cliente' => 'required|integer',
        'monto' => 'required|numeric',
        'fecha_inicio' => 'required|date',
        'cantidad_cuota' => 'required|integer',
        'tipo_prestamo' => 'required|string',
        'monto_cuota' => 'required|numeric',
        'frecuencia_pago' => 'required|string'
    ];

    /**
     * Relación con la tabla 'saldos' para obtener las cuotas de un préstamo.
     */
    public function saldos()
    {
        return $this->hasMany(Saldo::class, 'numero_prestamo', 'numero_prestamo');
    }
     public function cliente (){
     return $this-> belongsTo('App\Models\Cliente','id_cliente');

    }
     public function electrodomestico (){
     return $this-> belongsTo('App\Models\Electrodomestico','id_electrodomestico');

    }
}


