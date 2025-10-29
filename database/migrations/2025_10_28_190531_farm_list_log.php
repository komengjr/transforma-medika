<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmListLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_list_log', function (Blueprint $table) {
            $table->id('id_farm_list_log');
            $table->string('farm_list_log_code')->unique();
            $table->string('farm_list_log_reg');
            $table->string('farm_data_obat_code');
            $table->integer('farm_list_log_qty');
            $table->integer('farm_list_log_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farm_list_log');
    }
}
