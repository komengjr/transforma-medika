<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMouAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_mou_agreement', function (Blueprint $table) {
            $table->id('id_mou_agreement');
            $table->string('mou_agreement_code')->unique();
            $table->string('company_mou_code');
            $table->string('mou_agreement_name');
            $table->string('mou_agreement_status');
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
        Schema::dropIfExists('company_mou_agreement');
    }
}
