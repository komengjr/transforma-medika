<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLOrderRadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_order_rad', function (Blueprint $table) {
            $table->id('id_l_order_rad');
            $table->string('l_order_rad_code')->unique();
            $table->string('d_reg_order_rad_code');
            $table->string('p_pemeriksaan_data_code');
            $table->integer('l_order_rad_price');
            $table->string('l_order_rad_status');
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
        Schema::dropIfExists('l_order_rad');
    }
}
