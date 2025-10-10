<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePSalesDataSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_sales_data_sub', function (Blueprint $table) {
            $table->id('id_p_sales_data_sub');
            $table->string('p_sales_data_code')->unique();
            $table->string('p_sales_data_sub_code');
            $table->string('p_sales_data_sub_name');
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
        Schema::dropIfExists('p_sales_data_sub');
    }
}
