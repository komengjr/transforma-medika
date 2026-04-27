<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiMasterPesertaJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_peserta_job', function (Blueprint $table) {
            $table->id('id_kop_master_peserta_job');
            $table->string('kop_master_peserta_job_code')->unique();
            $table->string('kop_master_peserta_code');
            $table->string('kop_master_div_bag_code');
            $table->date('kop_master_peserta_job_first')->nullable();
            $table->date('kop_master_peserta_job_end')->nullable();
            $table->string('kop_master_peserta_job_status');
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
        Schema::dropIfExists('kop_master_peserta_job');
    }
}
