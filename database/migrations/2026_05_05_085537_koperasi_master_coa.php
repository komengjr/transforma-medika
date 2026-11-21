<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiMasterCoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_coa', function (Blueprint $table) {
            $table->id('id_kop_master_coa');
            $table->string('kop_master_coa_code')->unique();
            $table->integer('kop_master_coa_no');
            $table->string('kop_master_coa_name');
            $table->string('kop_master_coa_type');
            $table->string('kop_master_coa_jenis');
            $table->string('kop_master_coa_status');
            $table->timestamps();
        });
        Schema::create('kop_master_coa_data', function (Blueprint $table) {
            $table->id('id_kop_master_coa_data');
            $table->string('kop_coa_data_code')->unique();
            $table->string('kop_master_coa_code');
            $table->string('kop_coa_data_no');
            $table->string('kop_coa_data_name');
            $table->string('kop_coa_data_type');
            $table->string('kop_coa_data_level');
            $table->string('kop_coa_data_opt');
            $table->string('kop_coa_data_status');
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
        Schema::dropIfExists('kop_master_coa');
        Schema::dropIfExists('kop_master_coa_data');
    }
}
