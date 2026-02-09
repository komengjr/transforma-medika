<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventDataSubSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_data_sub_session', function (Blueprint $table) {
            $table->id('id_event_data_sub_session');
            $table->string('event_data_sub_session_code')->unique();
            $table->string('event_data_sub_code');
            $table->string('event_data_sub_session_name');
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
        Schema::dropIfExists('event_data_sub_session');
    }
}
