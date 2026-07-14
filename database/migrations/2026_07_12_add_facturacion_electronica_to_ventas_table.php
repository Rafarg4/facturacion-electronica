<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            if (!Schema::hasColumn('ventas', 'cdc')) {
                $table->string('cdc', 44)->nullable()->after('enviar_factura');
            }
            if (!Schema::hasColumn('ventas', 'estado_sifen')) {
                $table->string('estado_sifen')->nullable()->after('cdc');
            }
            if (!Schema::hasColumn('ventas', 'codigo_sifen')) {
                $table->string('codigo_sifen')->nullable()->after('estado_sifen');
            }
            if (!Schema::hasColumn('ventas', 'mensaje_sifen')) {
                $table->text('mensaje_sifen')->nullable()->after('codigo_sifen');
            }
            if (!Schema::hasColumn('ventas', 'fecha_envio_sifen')) {
                $table->timestamp('fecha_envio_sifen')->nullable()->after('mensaje_sifen');
            }
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn(['cdc', 'estado_sifen', 'codigo_sifen', 'mensaje_sifen', 'fecha_envio_sifen']);
        });
    }
};
