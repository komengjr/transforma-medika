<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventDataSubClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_data_sub_class', function (Blueprint $table) {
            $table->id('id_event_data_sub_class');
            $table->string('event_data_sub_class_code')->unique();
            $table->string('event_data_sub_code');
            $table->string('event_data_sub_class_name');
            $table->string('event_data_sub_class_room');
            $table->integer('event_data_sub_class_price');
            $table->integer('event_data_sub_class_kuota');
            $table->integer('event_data_sub_class_status');
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
        Schema::dropIfExists('event_data_sub_class');
    }
}
