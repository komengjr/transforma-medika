<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterfaceAlatArchitectCi4100Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interface_alat_architect_ci4100', function (Blueprint $table) {
            $table->id();
            $table->integer('instrument_id')->default(4100);
            $table->string('nolab')->index();         // Sample ID / Barcode Pasien
            $table->dateTime('tanggal')->nullable();   // Waktu Pemeriksaan
            $table->string('flag_qc')->default('N');
            $table->string('flag_query')->default('N');

            // Menyimpan array hasil parameter tes Kimia / Imunologi
            $table->json('results')->nullable();
            $table->json('raw_payload')->nullable();  // Seluruh payload JSON / ASTM mentah

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
        Schema::dropIfExists('interface_alat_architect_ci4100');
    }
}
