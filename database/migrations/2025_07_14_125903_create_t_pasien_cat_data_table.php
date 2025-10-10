<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPasienCatDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pasien_cat_data', function (Blueprint $table) {
            $table->id('id_t_pasien_cat_data');
            $table->string('t_pasien_cat_code');
            $table->string('t_pasien_cat_data_name');
            $table->string('t_pasien_cat_data_type');
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
        Schema::dropIfExists('t_pasien_cat_data');
    }
}
