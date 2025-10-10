<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPemeriksaanListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pemeriksaan_list', function (Blueprint $table) {
            $table->id('id_t_pemeriksaan_list');
            $table->string('t_pemeriksaan_list_code')->unique();
            $table->string('t_pemeriksaan_data_code');
            $table->string('t_pemeriksaan_list_name');
            $table->string('t_pemeriksaan_list_option');
            $table->string('t_pemeriksaan_list_type');
            $table->string('t_pemeriksaan_list_status');
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
        Schema::dropIfExists('t_pemeriksaan_list');
    }
}
