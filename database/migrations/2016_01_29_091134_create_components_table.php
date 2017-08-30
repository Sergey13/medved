<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 100);
            $table->string('number', 100)->unique();
            $table->integer('equipment_id')->unsigned();
            $table->integer('count');
            $table->string('provider', 255)->nullable();
            $table->string('provider_phone',100)->nullable();
            
            $table->foreign('equipment_id')->references('id')->on('equipments')
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
        Schema::drop('components');
    }
}
