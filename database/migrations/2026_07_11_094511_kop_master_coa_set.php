<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopMasterCoaSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_coa_set', function (Blueprint $table) {
            $table->id('id_kop_master_coa_set');
            $table->string('kop_master_coa_set_code')->unique();
            $table->string('kop_master_coa_set_name');
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
        Schema::dropIfExists('kop_master_coa_set');
    }
}
