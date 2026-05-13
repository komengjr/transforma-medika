<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiMasterBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_bank', function (Blueprint $table) {
            $table->id('id_kop_master_bank');
            $table->string('kop_master_bank_code')->unique();
            $table->string('kop_master_bank_id');
            $table->string('kop_master_bank_name');
            $table->string('kop_master_bank_number');
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
        Schema::dropIfExists('kop_master_bank');
    }
}
