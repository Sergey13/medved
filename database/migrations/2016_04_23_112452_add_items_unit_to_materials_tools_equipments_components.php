<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemsUnitToMaterialsToolsEquipmentsComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->string('unit', 10)->after('count')->default('peice');
        });

        Schema::table('equipments', function (Blueprint $table) {
            $table->string('unit', 10)->after('count')->default('peice');
        });
        Schema::table('tools', function (Blueprint $table) {
            $table->string('unit', 10)->after('count')->default('peice');
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->string('unit', 10)->after('count')->default('peice');
        });
        Schema::table('store', function (Blueprint $table) {
            $table->string('unit', 10)->after('count')->default('peice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
        Schema::table('equipments', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
        Schema::table('store', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }
}
