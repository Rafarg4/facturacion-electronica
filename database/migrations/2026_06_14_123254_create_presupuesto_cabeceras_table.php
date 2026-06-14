<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestoCabecerasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuesto_cabeceras', function (Blueprint $table) {
            $table->id('id');
            $table->text('cliente');
            $table->text('estado');
            $table->text('responsable');
            $table->text('descripcion');
            $table->text('sub_total');
            $table->text('total');
            $table->text('id_precio_lista');
            $table->text('tipo_presupuesto');
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
        Schema::drop('presupuesto_cabeceras');
    }
}
