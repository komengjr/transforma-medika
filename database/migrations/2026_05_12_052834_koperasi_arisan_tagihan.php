<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiArisanTagihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_arisan_tagihan', function (Blueprint $table) {
            $table->id('id_kop_arisan_tagihan');
            $table->string('kop_arisan_tagihan_code')->unique();
            $table->string('kop_arisan_group_code');
            $table->date('kop_arisan_tagihan_date');
            $table->integer('kop_arisan_tagihan_pokok');
            $table->integer('kop_arisan_tagihan_bunga');
            $table->integer('kop_arisan_tagihan_nominal');
            $table->integer('kop_arisan_tagihan_kuota');
            $table->string('kop_arisan_tagihan_terpilih')->nullable();
            $table->string('kop_arisan_tagihan_status');
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
        Schema::dropIfExists('kop_arisan_tagihan');
    }
}
