<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiMutasiBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_mutasi_bank', function (Blueprint $table) {
            $table->id('id_kop_mutasi_bank');
            $table->string('kop_mutasi_bank_code')->unique();
            $table->string('kop_master_bank_code');
            $table->string('kop_mutasi_bank_desc');
            $table->date('kop_mutasi_bank_date');
            $table->integer('kop_mutasi_bank_debit');
            $table->integer('kop_mutasi_bank_kredit');
            $table->integer('kop_mutasi_bank_total');
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
        Schema::dropIfExists('kop_mutasi_bank');
    }
}
