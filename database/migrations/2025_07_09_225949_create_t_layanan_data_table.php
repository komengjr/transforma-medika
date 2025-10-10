<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTLayananDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_layanan_data', function (Blueprint $table) {
            $table->id('id_t_layanan_data');
            $table->string('t_layanan_data_code')->unique();
            $table->string('t_layanan_cat_code');
            $table->string('t_layanan_data_name');
            $table->string('t_layanan_data_status');
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
        Schema::dropIfExists('t_layanan_data');
    }
}
