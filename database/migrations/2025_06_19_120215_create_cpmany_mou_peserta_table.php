<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpmanyMouPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_mou_peserta', function (Blueprint $table) {
            $table->id('id_mou_peserta');
            $table->string('mou_peserta_code')->unique();
            $table->string('company_mou_code');
            $table->string('mou_peserta_nik');
            $table->string('mou_peserta_nip');
            $table->string('mou_peserta_name');
            $table->string('mou_peserta_no_hp')->nullable();
            $table->string('mou_peserta_email')->nullable();
            $table->string('mou_peserta_ttl');
            $table->string('mou_peserta_jk');
            $table->string('mou_peserta_departemen');
            $table->string('mou_agreement_code')->nullable();
            $table->integer('mou_peserta_status')->nullable();
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
        Schema::dropIfExists('company_mou_peserta');
    }
}
