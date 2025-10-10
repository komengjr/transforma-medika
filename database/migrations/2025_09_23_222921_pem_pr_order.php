<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemPrOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pem_pr_order', function (Blueprint $table) {
            $table->id('id_pem_pr_order');
            $table->string('pem_pr_order_code')->unique();
            $table->string('pem_pr_req_code');
            $table->string('pem_pr_order_no');
            $table->string('pem_pr_order_date');
            $table->string('pem_pr_order_app');
            $table->integer('pem_pr_order_ppn');
            $table->integer('pem_pr_order_ppn_v');
            $table->float('pem_pr_order_discount');
            $table->string('pem_pr_order_create_by');
            $table->string('master_supplier_code');
            $table->string('pem_pr_order_payment');
            $table->string('pem_pr_order_do')->nullable();
            $table->string('pem_pr_order_status');
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
        Schema::dropIfExists('pem_pr_order');
    }
}
