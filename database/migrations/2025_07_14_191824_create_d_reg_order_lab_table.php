<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_lab', function (Blueprint $table) {
            $table->id('id_d_reg_order_lab');
            $table->string('d_reg_order_lab_code')->unique();
            $table->string('d_reg_order_code');
            $table->date('d_reg_order_lab_date'); // Ubah dari string ke date
            $table->string('d_reg_order_lab_number');
            $table->string('d_reg_order_lab_rujukan');
            $table->string('d_reg_order_lab_status');
            $table->string('d_reg_order_lab_user');
            $table->timestamps();

            $table->foreign('d_reg_order_code')->references('d_reg_order_code')->on('d_reg_order')->onDelete('cascade');
        });

        Schema::create('d_reg_order_lab_list', function (Blueprint $table) {
            $table->id('id_d_reg_order_lab_list');
            $table->string('order_lab_list_code')->unique();
            $table->string('d_reg_order_lab_code'); // Relasi ke Lab
            $table->string('p_sales_data_code');
            $table->integer('order_lab_log_price');
            $table->integer('order_lab_log_discount');
            $table->string('status_pembayaran');
            $table->timestamps();

            $table->foreign('d_reg_order_lab_code')->references('d_reg_order_lab_code')->on('d_reg_order_lab')->onDelete('cascade');
        });
        Schema::create('d_reg_order_lab_log', function (Blueprint $table) {
            $table->id('id_order_lab_log');
            $table->string('order_lab_log_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('p_sales_data_code');
            $table->integer('order_lab_log_price');
            $table->integer('order_lab_log_discount');
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
        Schema::dropIfExists('d_reg_order_lab');
        Schema::dropIfExists('d_reg_order_lab_list');
        Schema::dropIfExists('d_reg_order_lab_log');
    }
}
