<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id('id');
            $table->text('id_pedido');
            $table->text('fecha_compra');
            $table->text('tipo_comprobante');
            $table->text('numero_comprobante');
            $table->text('total');
            $table->text('iva');
            $table->text('forma_pago');
            $table->text('condicion_compra');
            $table->text('estado');
            $table->text('id_caja');
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
        Schema::drop('compras');
    }
}
