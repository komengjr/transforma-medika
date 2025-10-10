<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePSalesCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_sales_cat', function (Blueprint $table) {
            $table->id('id_p_sales_cat');
            $table->string('p_sales_cat_code')->unique();
            $table->string('p_sales_code');
            $table->string('t_layanan_cat_code');
            $table->string('p_sales_cat_name');
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
        Schema::dropIfExists('p_sales_cat');
    }
}
