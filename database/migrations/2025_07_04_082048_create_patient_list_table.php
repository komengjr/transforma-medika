<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_list', function (Blueprint $table) {
            $table->id('id_patient_list');
            $table->string('patient_list_reg')->unique();
            $table->string('master_patient_code');
            $table->date('patient_list_date');
            $table->string('master_layanan_code');
            $table->string('master_layanan_user');
            $table->string('master_layanan_status');
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
        Schema::dropIfExists('patient_list');
    }
}
