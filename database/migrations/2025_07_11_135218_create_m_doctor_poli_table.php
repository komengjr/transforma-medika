<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMDoctorPoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_doctor_poli', function (Blueprint $table) {
            $table->id('id_m_doctor_poli');
            $table->string('m_doctor_poli_code')->unique();
            $table->string('t_layanan_data_code');
            $table->string('master_doctor_code');
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
        Schema::dropIfExists('m_doctor_poli');
    }
}
