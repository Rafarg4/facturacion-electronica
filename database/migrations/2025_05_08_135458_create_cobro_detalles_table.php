<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobroDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobro_detalles', function (Blueprint $table) {
            $table->id();
            $table->text('id_cobro');
            $table->text('id_venta');
            $table->text('nro_cuota');
            $table->text('monto');
            $table->text('saldo');
            $table->text('estado'); 
            $table->text('fecha_vencimiento');


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
        Schema::dropIfExists('cobro_detalles');
    }
}
