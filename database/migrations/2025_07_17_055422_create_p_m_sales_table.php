<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePMSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_m_sales', function (Blueprint $table) {
            $table->id('id_p_m_sales');
            $table->string('p_m_sales_code')->unique();
            $table->string('p_m_sales_name');
            $table->string('p_m_sales_status');
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
        Schema::dropIfExists('p_m_sales');
    }
}
