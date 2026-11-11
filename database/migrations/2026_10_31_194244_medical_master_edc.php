<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalMasterEdc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_master_edc', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bank', 50); // Contoh: BCA, Mandiri, BNI
            $table->string('no_rekening', 50)->nullable(); // Nomor Rekening / Merchant ID
            $table->string('nama_pemilik', 100)->nullable(); // Nama akun EDC
            $table->string('nomor_seri_edc', 50)->nullable(); // Nomor mesin EDC (opsional)
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('medical_master_edc');
    }
}
