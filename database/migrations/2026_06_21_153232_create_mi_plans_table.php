<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiPlansTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mi_plans', function (Blueprint $table) {
            $table->id('id');
            $table->text('empresa');
            $table->text('nro_cuota');
            $table->date('fecha_vencimiento');
            $table->date('fecha_pago');
            $table->text('monto_cuota');
            $table->text('saldo_cuota');
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
        Schema::drop('mi_plans');
    }
}
