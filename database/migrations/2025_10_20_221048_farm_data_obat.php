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
            $table->string('farm_data_obat_harga_beli');
            $table->string('farm_data_obat_harga_jual');
            $table->string('farm_data_obat_stok');
            $table->string('farm_data_obat_stok_minimum');
            $table->string('farm_data_obat_tanggal_kedaluwarsa');
            $table->string('farm_data_obat_no_batch');
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
    }
}
