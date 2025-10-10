<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_patient', function (Blueprint $table) {
            $table->id('id_master_patient');
            $table->string('master_patient_code')->unique();
            $table->string('master_patient_nik')->unique();
            $table->string('master_patient_name');
            $table->string('master_patient_jk');
            $table->date('master_patient_tgl_lahir');
            $table->string('master_patient_tempat_lahir');
            $table->string('master_patient_agama');
            $table->string('master_patient_no_hp')->nullable();
            $table->string('master_patient_email')->nullable();
            $table->string('master_patient_place')->nullable();
            $table->text('master_patient_alamat')->nullable();
            $table->text('master_patient_profile')->nullable();
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
        Schema::dropIfExists('master_patient');
    }
}
