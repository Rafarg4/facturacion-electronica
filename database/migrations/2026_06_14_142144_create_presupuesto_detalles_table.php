<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestoDetallesTable extends Migration
{
    public function up()
    {
        Schema::create('presupuesto_detalles', function (Blueprint $table) {

            $table->id();
            $table->text('id_presupuesto_cabecera');
            $table->text('cantidad');
            $table->text('concepto');
            $table->text('total');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('presupuesto_detalles');
    }
}