<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HRegRad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_reg_rad', function (Blueprint $table) {
            $table->id('id_h_reg_rad');
            $table->string('h_reg_radcode')->unique();
            $table->string('order_rad_list_code');
            $table->string('t_pem_list_val_code');
            $table->string('h_reg_rad_flag');
            $table->text('h_reg_rad_value');
            $table->string('h_reg_rad_metode');
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
        Schema::dropIfExists('h_reg_rad');
    }
}
