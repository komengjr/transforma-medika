<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MPoliDoctorSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_poli_doctor_schedule', function (Blueprint $table) {
            $table->id('id_schedule');

            // Relasi ke tabel m_poli_doctor via pivot ID atau relasi kode
            $table->unsignedBigInteger('m_poli_doctor_id');
            $table->string('m_poli_code');
            $table->string('master_doctor_code');

            // Kolom Waktu & Hari
            $table->enum('day_name', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('quota')->default(0);
            $table->enum('status', ['AKTIF', 'NON-AKTIF'])->default('AKTIF');

            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('m_poli_doctor_id')
                ->references('id')
                ->on('m_poli_doctor')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_poli_doctor_schedule');
    }
}
