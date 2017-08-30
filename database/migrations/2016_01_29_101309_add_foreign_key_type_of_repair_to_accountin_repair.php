<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyTypeOfRepairToAccountinRepair extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_repair', function (Blueprint $table) {
            $table->foreign('type_of_repair_id')
                    ->references('id')->on('type_of_repair')
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
        Schema::table('accounting_repair', function (Blueprint $table) {
            $table->dropForeign('accounting_repair_type_of_repair_id_foreign');
        });
    }
}
