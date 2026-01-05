<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmKpiRekap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_kpi_rekap', function (Blueprint $table) {
            $table->id('id_hrm_kpi_rekap');
            $table->string('hrm_kpi_rekap_code')->unique();
            $table->string('hrm_m_pegawai_code');
            $table->string('hrm_kpi_rekap_periode');
            $table->string('hrm_kpi_rekap_total');
            $table->string('hrm_kpi_rekap_cat');
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
        Schema::dropIfExists('hrm_kpi_rekap');
    }
}
