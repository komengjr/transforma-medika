<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemPrOrderDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pem_pr_order_datas', function (Blueprint $table) {
            $table->id('id_pem_pr_order_datas');
            $table->string('pem_pr_order_datas_code')->unique();
            $table->string('pem_pr_order_code');
            $table->string('pem_pr_req_data_code');
            $table->integer('pem_pr_order_datas_qty');
            $table->integer('pem_pr_order_datas_harga');
            $table->integer('pem_pr_order_datas_discount');
            $table->integer('pem_pr_order_datas_status');
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
        Schema::dropIfExists('pem_pr_order_datas');
    }
}
