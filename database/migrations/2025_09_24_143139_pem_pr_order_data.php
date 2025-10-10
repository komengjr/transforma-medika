<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemPrOrderData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pem_pr_order_data', function (Blueprint $table) {
            $table->id('id_pem_pr_order_data');
            $table->string('pem_pr_order_data_code')->unique();
            $table->string('pem_pr_order_code');
            $table->string('pem_pr_req_data_code');
            $table->integer('pem_pr_order_data_qty');
            $table->integer('pem_pr_order_data_harga');
            $table->integer('pem_pr_order_data_discount');
            $table->integer('pem_pr_order_data_status');
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
        Schema::dropIfExists('pem_pr_order_data');
    }
}
