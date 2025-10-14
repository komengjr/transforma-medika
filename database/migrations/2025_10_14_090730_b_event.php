<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_event', function (Blueprint $table) {
            $table->id('id_b_event');
            $table->string('b_event_code')->unique();
            $table->string('b_event_name');
            $table->string('b_event_location');
            $table->string('b_event_class');
            $table->string('b_event_date');
            $table->string('b_event_status');
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
        Schema::dropIfExists('b_event');
    }
}
