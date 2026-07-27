<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTipoDocumentoToClientesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->enum('tipo_documento', ['RUC', 'CI', 'Extranjero'])->default('CI')->after('ci');
        });

        // Los clientes ya cargados cuyo campo "ci" tiene formato RUC-DV (ej. 80012345-6)
        // se venian tratando como RUC por deteccion de guion; se preserva ese comportamiento.
        DB::table('clientes')->where('ci', 'like', '%-%')->update(['tipo_documento' => 'RUC']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('tipo_documento');
        });
    }
}
