<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmKpiMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_kpi_master', function (Blueprint $table) {
            $table->id('id_hrm_kpi_master');
            $table->string('hrm_kpi_master_code')->unique();
            $table->string('hrm_departemen_code');
            $table->string('hrm_kpi_master_name');
            $table->text('hrm_kpi_master_desc');
            $table->string('hrm_kpi_master_bobot');
            $table->string('hrm_kpi_master_target');
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
        Schema::dropIfExists('hrm_kpi_master');
    }
}
