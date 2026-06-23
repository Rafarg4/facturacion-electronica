<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanIdToMiPlansTable extends Migration
{
    public function up()
    {
        Schema::table('mi_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable()->after('id');
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('cascade');
            $table->text('empresa')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('mi_plans', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');
        });
    }
}
