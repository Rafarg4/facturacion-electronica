<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('id');
            $table->text('id_cliente');
            $table->text('fecha_venta');
            $table->text('id_usuario');
            $table->text('tipo_comprobante');
            $table->text('numero_comprobante');
            $table->text('total');
            $table->text('id_caja');
            $table->text('condicion_venta');
            $table->text('iva');
            $table->text('forma_pago');
            $table->text('estado');
            $table->text('observacion');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ventas');
    }
}
