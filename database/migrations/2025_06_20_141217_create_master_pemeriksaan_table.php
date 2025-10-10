<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPemeriksaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_pemeriksaan', function (Blueprint $table) {
            $table->id('id_master_pemeriksaan');
            $table->string('master_pemeriksaan_code')->unique();
            $table->string('master_pemeriksaan_name');
            $table->string('master_pemeriksaan_status');
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
        Schema::dropIfExists('master_pemeriksaan');
    }
}
