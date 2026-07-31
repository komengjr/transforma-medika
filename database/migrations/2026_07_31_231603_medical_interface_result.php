<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalInterfaceResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_interface_result', function (Blueprint $table) {
            $table->id();
            $table->integer('instrument_id')->nullable();
            $table->string('nolab')->index();         // Nomor Lab / Sample ID
            $table->dateTime('tanggal')->nullable();   // Waktu Pemeriksaan
            $table->string('flag_qc')->default('N');
            $table->string('flag_query')->default('N');

            // Menyimpan array hasil tes (PX, Result, Flag) dan raw payload
            $table->json('results')->nullable();
            $table->json('raw_payload')->nullable();

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
        Schema::dropIfExists('medical_interface_result');
    }
}
