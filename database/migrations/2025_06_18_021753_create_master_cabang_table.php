<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_cabang', function (Blueprint $table) {
            $table->id('id_master_cabang');
            $table->string('master_cabang_code')->unique();
            $table->string('master_cabang_entitas');
            $table->string('master_cabang_name');
            $table->string('master_cabang_latitude');
            $table->string('master_cabang_longtitude');
            $table->string('master_cabang_city');
            $table->string('master_cabang_alamat');
            $table->string('master_cabang_phone');
            $table->string('master_cabang_status')->nullable();
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
        Schema::dropIfExists('master_cabang');
    }
}
