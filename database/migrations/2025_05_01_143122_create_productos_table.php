<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id');
            $table->text('nombre');
            $table->text('descripcion');
            $table->text('id_categoria');
            $table->text('cantidad');
            $table->text('cantidad_minima');
            $table->text('precio_venta');
            $table->text('precio_compra');
            $table->text('estado');
            $table->text('id_proveedor');
            $table->text('id_rubro');
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
        Schema::drop('productos');
    }
}
