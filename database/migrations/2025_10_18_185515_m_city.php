<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_city', function (Blueprint $table) {
            $table->id('id_m_city');
            $table->string('M_CityID')->unique();
            $table->string('M_CityName');
            $table->string('M_CityCode');
            $table->string('M_CityM_ProvinceID');
            $table->string('M_CityIsDefault');
            $table->string('M_CityCreated');
            $table->string('M_CityLastUpdated');
            $table->string('M_CityIsActive');
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
        Schema::dropIfExists('m_city');
    }
}
