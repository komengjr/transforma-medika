<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePSalesDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_sales_data', function (Blueprint $table) {
            $table->id('id_p_sales_data');
            $table->string('p_sales_data_code')->unique();
            $table->string('p_sales_cat_code');
            $table->string('p_sales_data_name');
            $table->string('p_sales_data_type');
            $table->integer('p_sales_data_price');
            $table->integer('p_sales_data_disc');
            $table->text('p_sales_data_desc');
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
        Schema::dropIfExists('p_sales_data');
    }
}
