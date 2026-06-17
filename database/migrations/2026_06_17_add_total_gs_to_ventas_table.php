<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('ventas', 'total_gs')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->text('total_gs')->nullable()->after('total');
            });
        }
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('total_gs');
        });
    }
};
