<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemGrnToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pem_grn_token', function (Blueprint $table) {
            $table->id('id_pem_grn_token');
            $table->string('pem_grn_token_code')->unique();
            $table->string('pem_pr_order_code')->index();
            $table->string('pem_grn_token_number');
            $table->string('pem_grn_token_do');
            $table->string('pem_grn_token_invoice')->nullable();
            $table->string('pem_grn_token_metode')->nullable();
            $table->integer('pem_grn_token_status');
            $table->date('pem_grn_token_date');
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
        Schema::dropIfExists('pem_grn_token');
    }
}
