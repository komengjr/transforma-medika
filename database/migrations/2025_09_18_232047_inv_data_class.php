<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvDataClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_data_class', function (Blueprint $table) {
            $table->id('id_inv_data_class');
            $table->string('id_inv_data_class_code')->unique();
            $table->string('inv_data_cat_code');
            $table->string('id_inv_data_class_name');
            $table->string('id_inv_data_class_pic')->nullable();
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
        Schema::dropIfExists('inv_data_class');
    }
}
