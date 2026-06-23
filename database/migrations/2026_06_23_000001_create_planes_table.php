<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanesTable extends Migration
{
    public function up()
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->text('empresa');
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->integer('cantidad_cuotas')->default(0);
            $table->decimal('monto_cuota', 15, 2)->default(0);
            $table->string('periodicidad')->default('mensual');
            $table->decimal('monto_total', 15, 2)->default(0);
            $table->string('estado')->default('Vigente');
            $table->text('observacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('planes');
    }
}
