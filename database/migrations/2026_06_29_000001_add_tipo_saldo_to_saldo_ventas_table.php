<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoSaldoToSaldoVentasTable extends Migration
{
    public function up()
    {
        Schema::table('saldo_ventas', function (Blueprint $table) {
            $table->string('tipo_saldo')->default('Venta')->after('estado');
        });
    }

    public function down()
    {
        Schema::table('saldo_ventas', function (Blueprint $table) {
            $table->dropColumn('tipo_saldo');
        });
    }
}
