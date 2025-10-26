<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmDataObatSale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_data_obat_sale', function (Blueprint $table) {
            $table->id('id_farm_data_obat_sale');
            $table->string('farm_data_obat_sale_code')->unique();
            $table->string('farm_data_obat_code');
            $table->string('master_supplier_code');
            $table->integer('farm_data_obat_sale_buy');
            $table->integer('farm_data_obat_sale_sell');
            $table->date('farm_data_obat_sale_date');
            $table->string('farm_data_obat_sale_desc');
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
        Schema::dropIfExists('farm_data_obat_sale');
    }
}
