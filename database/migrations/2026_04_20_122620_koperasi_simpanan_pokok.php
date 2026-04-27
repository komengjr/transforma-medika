<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiSimpananPokok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_simpanan_pokok', function (Blueprint $table) {
            $table->id('id_kop_simpanan_pokok');
            $table->string('kop_simpanan_pokok_code')->unique();
            $table->string('kop_simpanan_pokok_name');
            $table->integer('kop_simpanan_pokok_nominal');
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
        Schema::dropIfExists('kop_simpanan_pokok');
    }
}
