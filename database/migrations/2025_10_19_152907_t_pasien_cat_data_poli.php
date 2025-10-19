<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TPasienCatDataPoli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pasien_cat_data_poli', function (Blueprint $table) {
            $table->id('id_t_pasien_cat_data_poli');
            $table->string('id_t_pasien_cat_data');
            $table->string('d_reg_order_poli_code');
            $table->string('t_pasien_cat_data_poli_desc');
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
        Schema::dropIfExists('t_pasien_cat_data_poli');
    }
}
