<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvDataInvoiceD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_data_invoice_d', function (Blueprint $table) {
            $table->id('id_inv_data_invoice_d');
            $table->string('inv_data_invoice_d_code')->unique();
            $table->string('inv_data_invoice_code');
            $table->string('inv_data_master_code');
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
        Schema::dropIfExists('inv_data_invoice_d');
    }
}
