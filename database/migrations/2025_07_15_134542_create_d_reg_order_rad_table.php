<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderRadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_rad', function (Blueprint $table) {
            $table->id('id_d_reg_order_rad');
            $table->string('d_reg_order_rad_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('d_reg_order_rad_dr_rujukan');
            $table->string('d_reg_order_rad_dr_baca');
            $table->string('d_reg_order_rad_date');
            $table->text('d_reg_order_rad_desc');
            $table->string('d_reg_order_rad_number');
            $table->string('d_reg_order_rad_status');
            $table->string('d_reg_order_rad_user');
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
        Schema::dropIfExists('d_reg_order_rad');
    }
}
