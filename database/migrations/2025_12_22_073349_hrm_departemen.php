<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmDepartemen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_departemen', function (Blueprint $table) {
            $table->id('id_hrm_departemen');
            $table->string('hrm_departemen_code')->unique();
            $table->string('hrm_departemen_name');
            $table->string('hrm_departemen_lokasi');
            $table->string('hrm_departemen_kepala');
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
        Schema::dropIfExists('hrm_departemen');
    }
}
