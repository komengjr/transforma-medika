<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatMasterDoctorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_doctor', function (Blueprint $table) {
            $table->id('id_master_doctor');
            $table->string('master_doctor_code')->unique();
            $table->string('master_doctor_nik');
            $table->string('master_doctor_title_f');
            $table->string('master_doctor_name');
            $table->string('master_doctor_title_e');
            $table->string('master_doctor_jk');
            $table->string('master_doctor_hp');
            $table->string('master_doctor_email');
            $table->text('master_doctor_profile');
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
        Schema::dropIfExists('master_doctor');
    }
}
