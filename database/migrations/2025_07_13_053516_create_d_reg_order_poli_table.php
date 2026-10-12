<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDRegOrderPoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_reg_order_poli', function (Blueprint $table) {
            $table->id('id_d_reg_order_poli');
            $table->string('d_reg_order_poli_code')->unique();
            $table->string('d_reg_order_code');
            $table->string('m_doctor_poli_code');
            $table->date('d_reg_order_poli_date');
            $table->enum('d_reg_order_poli_status', ['MENUNGGU', 'DILAYANI', 'SELESAI', 'BATAL'])->default('MENUNGGU'); // Duplikat dihapus, gunakan enum ini
            $table->string('d_reg_order_poli_user');
            $table->string('d_reg_order_poli_queue');
            $table->string('m_poli_code');
            $table->unsignedBigInteger('schedule_id');
            $table->date('d_reg_order_poli_visit');
            $table->string('payment_method');
            $table->string('insurance_no')->nullable();
            $table->timestamps();

            $table->foreign('d_reg_order_code')->references('d_reg_order_code')->on('d_reg_order')->onDelete('cascade');
        });
        Schema::create('d_reg_order_poli_list', function (Blueprint $table) {
            $table->id('id_d_reg_order_poli_list');
            $table->string('order_poli_list_code')->unique();
            $table->string('d_reg_order_poli_code'); // Relasi ke Poli, bukan order utama
            $table->string('p_sales_data_code');
            $table->integer('order_poli_log_price'); // Ubah dari string ke integer
            $table->integer('order_poli_log_discount'); // Ubah dari string ke integer
            $table->string('status_pembayaran');
            $table->timestamps();

            $table->foreign('d_reg_order_poli_code')->references('d_reg_order_poli_code')->on('d_reg_order_poli')->onDelete('cascade');
        });
        Schema::create('d_reg_order_poli_log', function (Blueprint $table) {
            $table->id('id_order_poli_log');
            $table->string('order_poli_log_code')->unique();
            $table->string('d_reg_order_poli_code');
            $table->string('p_sales_data_code');
            $table->integer('order_poli_log_price');
            $table->integer('order_poli_log_discount');
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
        Schema::dropIfExists('d_reg_order_poli');
        Schema::dropIfExists('d_reg_order_poli_list');
        Schema::dropIfExists('d_reg_order_poli_log');
    }
}
