<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiVocherCat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_vocher_cat', function (Blueprint $table) {
            $table->id('id_kop_vocher_cat');
            $table->string('kop_vocher_cat_code')->unique();
            $table->string('kop_vocher_cat_name');
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
        Schema::dropIfExists('kop_vocher_cat');
    }
}
