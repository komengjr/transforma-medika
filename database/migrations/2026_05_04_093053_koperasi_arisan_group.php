<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiArisanGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_arisan_group', function (Blueprint $table) {
            $table->id('id_kop_arisan_group');
            $table->string('kop_arisan_group_code')->unique();
            $table->string('kop_arisan_group_name');
            $table->date('kop_arisan_group_date_start');
            $table->date('kop_arisan_group_date_end');
            $table->integer('kop_arisan_group_nominal');
            $table->integer('kop_arisan_group_bunga');
            $table->string('kop_arisan_group_cabang');
            $table->string('kop_arisan_group_status');
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
        Schema::dropIfExists('kop_arisan_group');
    }
}
