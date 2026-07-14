<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('koape_credenciales', function (Blueprint $table) {
            $table->id();
            $table->string('usuario');
            $table->text('password');
            $table->text('codigo_acceso');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('koape_credenciales');
    }
};
