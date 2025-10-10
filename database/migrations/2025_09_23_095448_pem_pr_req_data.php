<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemPrReqData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pem_pr_req_data', function (Blueprint $table) {
            $table->id('id_pem_pr_req_data');
            $table->string('pem_pr_req_data_code')->unique();
            $table->string('pem_pr_req_code');
            $table->string('pem_pr_req_data_name');
            $table->string('pem_pr_req_data_type');
            $table->integer('pem_pr_req_data_qty');
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
        Schema::dropIfExists('pem_pr_req_data');
    }
}
