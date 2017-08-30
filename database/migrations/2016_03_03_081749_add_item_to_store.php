<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemToStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store', function (Blueprint $table) {
            $table->integer('equipment_id')->nullable()->unsigned();
            $table->integer('tool_id')->nullable()->unsigned();
            $table->integer('material_id')->nullable()->unsigned();
            
            $table->foreign('equipment_id')->references('id')->on('equipments')
                    ->onDelete('cascade');
            $table->foreign('tool_id')->references('id')->on('tools')
                    ->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store', function (Blueprint $table) {
            $table->dropColumn('equipment_id');
            $table->dropColumn('tool_id');
            $table->dropColumn('material_id');
        });
    }
}
