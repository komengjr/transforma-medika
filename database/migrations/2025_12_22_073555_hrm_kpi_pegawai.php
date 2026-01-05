<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmKpiPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_kpi_pegawai', function (Blueprint $table) {
            $table->id('id_hrm_kpi_pegawai');
            $table->string('hrm_kpi_pegawai_code')->unique();
            $table->string('hrm_m_pegawai_code');
            $table->string('hrm_kpi_master_code');
            $table->string('hrm_kpi_pegawai_periode');
            $table->string('hrm_kpi_pegawai_value');
            $table->string('hrm_kpi_pegawai_score');
            $table->string('hrm_kpi_pegawai_evaluator');
            $table->string('hrm_kpi_pegawai_catatan');
            $table->string('hrm_kpi_pegawai_status');
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
        Schema::dropIfExists('hrm_kpi_pegawai');
    }
}
