<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeItemCountToMaterialsStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->decimal('count', 5, 2)->change();
        });
        Schema::table('store', function (Blueprint $table) {
            $table->decimal('count', 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->integer('count')->change();
        });
        Schema::table('store', function (Blueprint $table) {
            $table->integer('count')->change();
        });
    }
}
