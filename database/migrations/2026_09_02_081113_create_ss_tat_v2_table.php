<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsTatV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_tat_v2', function (Blueprint $table) {
            $table->integer('SsTatV2ID', true); // Auto-increment Primary Key
            $table->date('SsTatV2Date')->nullable()->index('SsTatV2Date'); // Index ditambahkan pada kolom ini
            $table->decimal('SsTatV2Month', 15, 2)->nullable();
            $table->decimal('SsTatV2FoTargetEntry', 15, 2)->nullable();
            $table->decimal('SsTatV2FoVerif', 15, 2)->nullable();
            $table->decimal('SsTatV2FoTotalData', 15, 2)->nullable();
            $table->decimal('SsTatV2FoPctFo', 15, 2)->nullable();
            $table->decimal('SsTatV2FoPctVerif', 15, 2)->nullable();
            $table->decimal('SsTatV2SamplingData', 15, 2)->nullable();
            $table->decimal('SsTatV2SamplingHasil', 15, 2)->nullable();
            $table->decimal('SsTatV2SamplingPct', 15, 2)->nullable();
            $table->decimal('SsTatV2VerifData', 15, 2)->nullable();
            $table->decimal('SsTatV2VerifHasil', 15, 2)->nullable();
            $table->decimal('SsTatV2VerifPct', 15, 2)->nullable();
            $table->decimal('SsTatV2PengolahanData', 15, 2)->nullable();
            $table->decimal('SsTatV2PengolahanHasil', 15, 2)->nullable();
            $table->decimal('SsTatV2PengolahanPct', 15, 2)->nullable();
            $table->decimal('SsTatV2ValidasiData', 15, 2)->nullable();
            $table->decimal('SsTatV2ValidasiHasil', 15, 2)->nullable();
            $table->decimal('SsTatV2ValidasiPct', 15, 2)->nullable();
            $table->decimal('SsTatV2AdmLabData', 15, 2)->nullable();
            $table->decimal('SsTatV2AdmLabHasil', 15, 2)->nullable();
            $table->decimal('SsTatV2AdmLabPct', 15, 2)->nullable();
            $table->decimal('SsTatV2FullLabData', 15, 2)->nullable();
            $table->decimal('SsTatV2FullLabHasil', 15, 2)->nullable();
            $table->decimal('SsTatV2FullLabPct', 15, 2)->nullable();
        });
        Schema::create('ss_tat_v2_nonlab', function (Blueprint $table) {
            $table->integer('SsTatV2NonLabID', true); // Auto-increment Primary Key
            $table->date('SsTatV2NonLabDate')->nullable()->index('SsTatV2NonLabDate');
            $table->integer('SsTatV2NonLabNat_GroupID')->nullable()->index('SsTatV2NonLabNat_GroupID');
            $table->string('SsTatV2NonLabNat_GroupName', 150)->nullable()->index('SsTatV2NonLabNat_GroupName');

            $table->decimal('SsTatV2NonLabHandlingData', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabHandling', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabHandlingPct', 15, 2)->nullable();

            $table->decimal('SsTatV2NonLabVerifikasiData', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabVerifikasi', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabVerifikasiPct', 15, 2)->nullable();

            $table->decimal('SsTatV2NonLabHandlingImageData', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabHandlingImage', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabHandlingImagePct', 15, 2)->nullable();

            $table->decimal('SsTatV2NonLabValidasiData', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabValidasi', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabValidasiPct', 15, 2)->nullable();

            $table->decimal('SsTatV2NonLabTerimaFoData', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabTerimaFo', 15, 2)->nullable()->comment('i');
            $table->decimal('SsTatV2NonLabTerimaFoPct', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_tat_v2');
        Schema::dropIfExists('ss_tat_v2_nonlab');
    }
}
