<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderElektromedis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_em', function (Blueprint $table) {
            $table->id('id_d_reg_order_em');
            $table->string('d_reg_order_em_code')->unique();
            $table->string('d_reg_order_code'); // Relasi ke order utama
            $table->string('d_reg_order_em_dr_rujukan')->nullable();
            $table->date('d_reg_order_em_date');
            $table->text('d_reg_order_em_desc')->nullable();
            $table->string('d_reg_order_em_status');
            $table->string('d_reg_order_em_user');
            $table->timestamps();

            $table->foreign('d_reg_order_code')->references('d_reg_order_code')->on('d_reg_order')->onDelete('cascade');
        });

        Schema::create('d_reg_order_em_list', function (Blueprint $table) {
            $table->id('id_d_reg_order_em_list');
            $table->string('order_em_list_code')->unique();
            $table->string('d_reg_order_em_code'); // Relasi ke Elektromedis
            $table->string('p_sales_data_code');
            $table->integer('order_em_log_price');
            $table->integer('order_em_log_discount');
            $table->string('status_pembayaran');
            $table->timestamps();

            $table->foreign('d_reg_order_em_code')->references('d_reg_order_em_code')->on('d_reg_order_em')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_reg_order_em');
        Schema::dropIfExists('d_reg_order_em_list');
    }
}
