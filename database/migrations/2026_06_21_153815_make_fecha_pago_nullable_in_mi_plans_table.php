<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFechaPagoNullableInMiPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mi_plans', function (Blueprint $table) {
            $table->date('fecha_pago')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('mi_plans', function (Blueprint $table) {
            $table->date('fecha_pago')->nullable(false)->change();
        });
    }
}
