<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMouAgreementSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_mou_agreement_sub', function (Blueprint $table) {
            $table->id('id_mou_agreement_sub');
            $table->string('mou_agreement_code');
            $table->string('master_pemeriksaan_code');
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
        Schema::dropIfExists('company_mou_agreement_sub');
    }
}
