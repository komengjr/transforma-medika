<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('menu_code')->unique();
            $table->string('menu_super_code');
            $table->string('menu_name');
            $table->string('menu_link');
            $table->string('menu_icon')->nullable();
            $table->string('menu_status');
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
        Schema::dropIfExists('z_menu');
    }
}
