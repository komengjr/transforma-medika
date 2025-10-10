<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvDataInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_data_invoice', function (Blueprint $table) {
            $table->id('id_inv_data_invoice');
            $table->string('inv_data_invoice_code')->unique();
            $table->string('inv_data_invoice_no');
            $table->string('inv_data_invoice_harga');
            $table->string('inv_data_invoice_tgl');
            $table->string('master_supplier_code');
            $table->string('inv_data_invoice_type');
            $table->text('inv_data_invoice_file')->nullable();
            $table->string('inv_data_invoice_status');
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
        Schema::dropIfExists('inv_data_invoice');
    }
}
