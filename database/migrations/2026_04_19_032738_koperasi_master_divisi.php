<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiMasterDivisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_divisi', function (Blueprint $table) {
            $table->id('id_kop_master_divisi');
            $table->string('kop_master_divisi_code')->unique();
            $table->string('kop_master_divisi_name');
            $table->string('kop_master_divisi_type');
            $table->string('kop_master_divisi_status');
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
        Schema::dropIfExists('kop_master_divisi');
    }
}
