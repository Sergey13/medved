<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_repair', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('type_of_repair_id')->unsigned()->nullable();
            $table->date('date');
            $table->integer('performer_id')->unsigned()->nullable();
            $table->integer('schedule_id')->unsigned()->nullable();
            $table->integer('equipment_id')->unsigned()->nullable();
            $table->integer('component_id')->unsigned()->nullable();
            
            $table->foreign('schedule_id')->references('id')->on('schedule')
                    ->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipments')
                    ->onDelete('cascade');
            $table->foreign('component_id')->references('id')->on('components')
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
        Schema::drop('accounting_repair');
    }
}
