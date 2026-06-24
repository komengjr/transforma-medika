<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiReqTagihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_req_tagihan', function (Blueprint $table) {
            $table->id('id_kop_req_tagihan');
            $table->string('kop_req_tagihan_code')->unique();
            $table->date('kop_req_tagihan_date');
            $table->string('kop_req_tagihan_type');
            $table->string('kop_req_tagihan_id');
            $table->string('kop_req_tagihan_token');
            $table->decimal('kop_req_tagihan_nominal', 15, 2);
            $table->string('kop_req_tagihan_status');
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
        Schema::dropIfExists('kop_req_tagihan');
    }
}
