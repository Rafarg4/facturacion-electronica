<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cobro_detalles', function (Blueprint $table) {
            if (!Schema::hasColumn('cobro_detalles', 'tipo_saldo')) {
                $table->string('tipo_saldo')->default('Venta')->after('nro_cuota');
            }
        });
    }

    public function down()
    {
        Schema::table('cobro_detalles', function (Blueprint $table) {
            $table->dropColumn('tipo_saldo');
        });
    }
};
