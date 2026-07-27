<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('koape_credenciales', function (Blueprint $table) {
            $table->string('base_url')->nullable()->after('codigo_acceso');
            $table->string('establecimiento')->nullable()->after('base_url');
            $table->string('punto_expedicion')->nullable()->after('establecimiento');
        });
    }

    public function down()
    {
        Schema::table('koape_credenciales', function (Blueprint $table) {
            $table->dropColumn(['base_url', 'establecimiento', 'punto_expedicion']);
        });
    }
};
