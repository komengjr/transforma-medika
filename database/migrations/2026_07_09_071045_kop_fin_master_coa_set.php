<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopFinMasterCoaSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_fin_master_coa_set', function (Blueprint $table) {
            $table->id('id_fin_master_coa_set');
            $table->string('fin_master_coa_set_code')->unique();
            $table->string('fin_master_coa_set_cabang');
            $table->string('fin_master_coa_set_type');
            $table->string('fin_master_coa_set_trx');
            $table->string('fin_master_coa_set_debit');
            $table->string('fin_master_coa_set_adm');
            $table->string('fin_master_coa_set_bunga');
            $table->string('fin_master_coa_set_kredit');
            $table->string('fin_master_coa_set_status');
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
        Schema::dropIfExists('kop_fin_master_coa_set');
    }
}
