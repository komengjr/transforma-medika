<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemPrReq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pem_pr_req', function (Blueprint $table) {
            $table->id('id_pem_pr_req');
            $table->string('pem_pr_req_code')->unique();
            $table->string('pem_pr_req_nomor');
            $table->string('pem_pr_req_name');
            $table->date('pem_pr_req_date');
            $table->date('pem_pr_req_date_require');
            $table->string('pem_pr_req_by');
            $table->string('pem_pr_req_app_by');
            $table->string('pem_pr_req_create_by');
            $table->string('pem_pr_req_status');
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
        Schema::dropIfExists('pem_pr_req');
    }
}
