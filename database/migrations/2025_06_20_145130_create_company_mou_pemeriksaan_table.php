<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMouPemeriksaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_mou_pemeriksaan', function (Blueprint $table) {
            $table->id('id_mou_pemeriksaan');
            $table->string('mou_pemeriksaan_code')->unique();
            $table->string('company_mou_code');
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
        Schema::dropIfExists('company_mou_pemeriksaan');
    }
}
