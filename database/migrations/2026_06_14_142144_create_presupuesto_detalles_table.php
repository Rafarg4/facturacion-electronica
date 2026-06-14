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

            $table->unsignedBigInteger('id_presupuesto_cabecera');
            $table->text('cantidad');
            $table->string('concepto', 255);
            $table->text('precio_unitario')->default(0);
            $table->text('total')->default(0);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('presupuesto_detalles');
    }
}