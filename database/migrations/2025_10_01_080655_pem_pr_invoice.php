<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemPrInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pem_pr_invoice', function (Blueprint $table) {
            $table->id('id_pem_pr_invoice');
            $table->string('pem_pr_invoice_code')->unique();
            $table->string('pem_grn_token_code');
            $table->string('pem_pr_order_code');
            $table->string('pem_pr_invoice_no');
            $table->integer('pem_pr_invoice_price');
            $table->string('pem_pr_invoice_status');
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
        Schema::dropIfExists('pem_pr_invoice');
    }
}
