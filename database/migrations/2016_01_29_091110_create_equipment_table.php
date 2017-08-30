<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 100);
            $table->bigInteger('inventory_number')->unique();
            $table->longText('pasport')->nullable();
            $table->integer('place_id')->unsigned();
            $table->date('installation_date');
            $table->string('document', 255)->nullable();
            
            $table->foreign('place_id')->references('id')->on('places')
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
        Schema::drop('equipments');
    }
}
