<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('presupuesto_cabeceras', function (Blueprint $table) {
            $table->text('total_gs')->nullable()->after('total');
        });
    }

    public function down()
    {
        Schema::table('presupuesto_cabeceras', function (Blueprint $table) {
            $table->dropColumn('total_gs');
        });
    }
};
