<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_registrations', function (Blueprint $table) {
            $table->id('id_registration');
            $table->string('queue_number');
            $table->unsignedBigInteger('patient_id'); // Merujuk ke id_master_patient
            $table->string('m_poli_code');
            $table->unsignedBigInteger('schedule_id');
            $table->date('visit_date');
            $table->string('payment_method'); // UMUM, BPJS, ASURANSI
            $table->string('insurance_no')->nullable();
            $table->enum('status', ['MENUNGGU', 'DILAYANI', 'SELESAI', 'BATAL'])->default('MENUNGGU');
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
        Schema::dropIfExists('t_registrations');
    }
}
