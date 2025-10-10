<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpmanyMouTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_mou', function (Blueprint $table) {
            $table->id('id_company_mou');
            $table->string('company_mou_code')->unique();
            $table->string('master_company_code');
            $table->string('company_mou_name');
            $table->string('company_mou_peserta');
            $table->date('company_mou_start');
            $table->date('company_mou_end');
            $table->string('company_mou_persentasi')->nullable();
            $table->text('company_mou_persentasi_r')->nullable();
            $table->string('company_mou_excecutive')->nullable();
            $table->text('company_mou_excecutive_r')->nullable();
            $table->string('company_mou_healty_talk')->nullable();
            $table->string('company_mou_status');
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
        Schema::dropIfExists('company_mou');
    }
}
