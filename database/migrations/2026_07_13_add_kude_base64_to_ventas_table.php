<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('ventas', 'kude_base64')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->longText('kude_base64')->nullable()->after('qr_base64');
            });
        }
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('kude_base64');
        });
    }
};
