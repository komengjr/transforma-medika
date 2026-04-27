<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiMasterDivBag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_div_bag', function (Blueprint $table) {
            $table->id('id_kop_master_div_bag');
            $table->string('kop_master_div_bag_code')->unique();
            $table->string('kop_master_divisi_code');
            $table->string('kop_master_div_bag_name');
            $table->string('kop_master_div_bag_lvl');
            $table->string('kop_master_div_bag_status');
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
        Schema::dropIfExists('kop_master_div_bag');
    }
}
