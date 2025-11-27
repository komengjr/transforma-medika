<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_data', function (Blueprint $table) {
            $table->id('id_event_data');
            $table->string('event_data_code')->unique();
            $table->string('event_data_tittle');
            $table->dateTime('event_data_start_date');
            $table->dateTime('event_data_end_date');
            $table->dateTime('event_data_reg_deadline');
            $table->string('event_data_venue');
            $table->string('event_data_address');
            $table->string('event_data_city');
            $table->string('event_data_state');
            $table->text('event_data_desc');
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
        Schema::dropIfExists('event_data');
    }
}
