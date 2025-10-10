<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPemeriksaanCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pemeriksaan_cat', function (Blueprint $table) {
            $table->id('id_t_pemeriksaan_cat');
            $table->string('t_pemeriksaan_cat_code')->unique();
            $table->string('t_pemeriksaan_cat_name');
            $table->string('t_pemeriksaan_cat_status');
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
        Schema::dropIfExists('t_pemeriksaan_cat');
    }
}
