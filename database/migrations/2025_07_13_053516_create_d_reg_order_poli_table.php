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
            $table->string('d_reg_order_poli_status');
            $table->string('d_reg_order_poli_user');
            $table->string('d_reg_order_poli_queue');
            // $table->unsignedBigInteger('patient_id'); // Merujuk ke id_master_patient
            $table->string('m_poli_code');
            $table->unsignedBigInteger('schedule_id');
            $table->date('d_reg_order_poli_visit');
            $table->string('payment_method'); // UMUM, BPJS, ASURANSI
            $table->string('insurance_no')->nullable();
            $table->enum('d_reg_order_poli_status', ['MENUNGGU', 'DILAYANI', 'SELESAI', 'BATAL'])->default('MENUNGGU');
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
    }
}
