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
            $table->date('d_reg_order_rad_date'); // Ubah dari string ke date
            $table->text('d_reg_order_rad_desc');
            $table->string('d_reg_order_rad_number');
            $table->string('d_reg_order_rad_status');
            $table->string('d_reg_order_rad_user');
            $table->timestamps();

            $table->foreign('d_reg_order_code')->references('d_reg_order_code')->on('d_reg_order')->onDelete('cascade');
        });

        Schema::create('d_reg_order_rad_list', function (Blueprint $table) {
            $table->id('id_d_reg_order_rad_list');
            $table->string('order_rad_list_code')->unique();
            $table->string('d_reg_order_rad_code'); // Relasi ke Rad
            $table->string('p_sales_data_code');
            $table->integer('order_rad_log_price');
            $table->integer('order_rad_log_discount');
            $table->string('status_pembayaran');
            $table->timestamps();

            $table->foreign('d_reg_order_rad_code')->references('d_reg_order_rad_code')->on('d_reg_order_rad')->onDelete('cascade');
        });
        Schema::create('d_reg_order_rad_log', function (Blueprint $table) {
            $table->id('id_order_rad_log');
            $table->string('order_rad_log_code')->unique();
            $table->string('d_reg_order_rad_code');
            $table->string('p_sales_data_code');
            $table->integer('order_rad_log_price');
            $table->integer('order_rad_log_discount');
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
        Schema::dropIfExists('d_reg_order_rad_list');
        Schema::dropIfExists('d_reg_order_rad_log');
    }
}
