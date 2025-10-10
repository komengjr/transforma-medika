<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZMenuSuperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_menu_super', function (Blueprint $table) {
            $table->id('menu_super');
            $table->string('menu_super_code')->unique();
            $table->string('menu_super_name');
            $table->text('menu_super_link');
            $table->string('menu_super_icon');
            $table->string('menu_super_status');
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
        Schema::dropIfExists('z_menu_super');
    }
}
