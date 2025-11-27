<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventDataSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_data_sub', function (Blueprint $table) {
            $table->id('id_event_data_sub');
            $table->string('event_data_sub_code')->unique();
            $table->string('event_data_code');
            $table->string('event_data_sub_name');
            $table->dateTime('event_data_sub_start');
            $table->dateTime('event_data_sub_end');
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
        Schema::dropIfExists('event_data_sub');
    }
}
