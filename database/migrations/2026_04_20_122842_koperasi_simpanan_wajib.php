<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiSimpananWajib extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_simpanan_wajib', function (Blueprint $table) {
            $table->id('id_kop_simpanan_wajib');
            $table->string('kop_simpanan_wajib_code')->unique();
            $table->string('kop_simpanan_wajib_name');
            $table->integer('kop_simpanan_wajib_nominal');
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
        Schema::dropIfExists('kop_simpanan_wajib');
    }
}
