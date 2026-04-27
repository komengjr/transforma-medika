<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiMasterCabang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_cabang', function (Blueprint $table) {
            $table->id('id_kop_master_cabang');
            $table->string('kop_master_cabang_code')->unique();
            $table->string('kop_master_cabang_name');
            $table->string('kop_master_cabang_city');
            $table->string('kop_master_cabang_alamat');
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
        Schema::dropIfExists('kop_master_cabang');
    }
}
