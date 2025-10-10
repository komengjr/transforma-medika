<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPemeriksaanDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pemeriksaan_data', function (Blueprint $table) {
            $table->id('id_t_pemeriksaan_data');
            $table->string('t_pemeriksaan_data_code')->unique();
            $table->string('t_pemeriksaan_cat_code');
            $table->string('t_pemeriksaan_data_name');
            $table->string('t_pemeriksaan_data_status');
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
        Schema::dropIfExists('t_pemeriksaan_data');
    }
}
