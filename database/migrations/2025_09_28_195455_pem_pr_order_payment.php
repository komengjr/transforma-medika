<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemPrOrderPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pem_pr_order_payment', function (Blueprint $table) {
            $table->id('id_pem_pr_order_payment');
            $table->string('pem_pr_order_payment_code')->unique();
            $table->string('pem_pr_order_code');
            $table->string('m_pay_detail_code');
            $table->date('pem_pr_order_payment_termin');
            $table->string('pem_pr_order_payment_no_rek');
            $table->string('pem_pr_order_payment_price');
            $table->string('pem_pr_order_payment_status');
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
        Schema::dropIfExists('pem_pr_order_payment');
    }
}
