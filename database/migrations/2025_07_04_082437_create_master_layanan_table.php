<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_layanan', function (Blueprint $table) {
            $table->id('id_master_layanan');
            $table->string('master_layanan_code')->unique();
            $table->string('master_layanan_name');
            $table->string('master_layanan_type');
            $table->string('master_layanan_status');
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
        Schema::dropIfExists('master_layanan');
    }
}
