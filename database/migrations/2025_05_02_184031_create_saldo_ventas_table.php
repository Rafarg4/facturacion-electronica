<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_ventas', function (Blueprint $table) {
            $table->id();
            $table->text('id_venta');    // Relación con la venta
            $table->text('id_cliente');  // Relación con el cliente
            $table->text('monto');
             $table->text('saldo');
            $table->text('numero_cuota');
            $table->text('estado');           // Monto a pagar
            $table->date('fecha_vencimiento');         // Fecha de vencimiento de la cuota
            $table->boolean('pagado')->default(false); // Si ya fue pagado o no
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saldo_ventas');
    }
}
