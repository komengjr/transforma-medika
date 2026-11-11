<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmDataObat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_data_obat', function (Blueprint $table) {
            $table->id('id_farm_data_obat');
            $table->string('farm_data_obat_code')->unique();
            $table->string('farm_data_obat_name');
            $table->string('farm_data_obat_cat');
            $table->string('farm_data_obat_jenis');
            $table->string('farm_data_obat_satuan');
            $table->string('farm_data_obat_stok');
            $table->string('farm_data_obat_stok_minimum');
            $table->timestamps();
        });
        Schema::create('farm_data_obat_sale', function (Blueprint $table) {
            $table->id('id_farm_data_obat_sale');
            $table->string('farm_data_obat_sale_code')->unique();
            $table->string('farm_data_obat_code');
            $table->string('pem_grn_token_code');
            $table->integer('farm_data_obat_sale_buy');
            $table->integer('farm_data_obat_sale_sell');
            $table->date('farm_data_obat_sale_date');
            $table->string('farm_data_obat_sale_desc');
            $table->timestamps();
        });
        Schema::create('farm_data_obat_exp', function (Blueprint $table) {
            $table->id('id_farm_data_obat_exp');
            $table->string('farm_data_obat_exp_code')->unique();
            $table->string('farm_data_obat_code');
            $table->string('pem_grn_token_code');
            $table->date('data_obat_tanggal_masuk');
            $table->date('data_obat_tanggal_exp');
            $table->integer('data_obat_stok');
            $table->string('data_obat_rak');
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
        Schema::dropIfExists('farm_data_obat');
        Schema::dropIfExists('farm_data_obat_sale');
        Schema::dropIfExists('farm_data_obat_exp');
    }
}
