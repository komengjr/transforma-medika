<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiArisanGroupUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_arisan_group_user', function (Blueprint $table) {
            $table->id('di_kop_arisan_group_user');
            $table->string('kop_arisan_group_user_code')->unique();
            $table->string('kop_arisan_group_code');
            $table->string('kop_master_peserta_code');
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
        Schema::dropIfExists('kop_arisan_group_user');
    }
}
