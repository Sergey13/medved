<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('component_id')->unsigned();
            $table->dateTime('date');
            $table->integer('count');
            $table->integer('performer_id')->unsigned()->nullable();
            $table->string('type', 50);
            
            $table->foreign('component_id')->references('id')->on('components')
                    ->onDelete('cascade');
            $table->foreign('performer_id')->references('id')->on('performers')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('store');
    }
}
