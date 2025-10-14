<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BEventPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_event_peserta', function (Blueprint $table) {
            $table->id('id_b_event_peserta');
            $table->string('b_event_peserta_code')->unique();
            $table->string('b_event_code');
            $table->string('b_event_peserta_name');
            $table->string('b_event_peserta_booking');
            $table->string('b_event_peserta_class');
            $table->string('b_event_peserta_room');
            $table->string('b_event_peserta_hp');
            $table->string('b_event_peserta_email');
            $table->string('b_event_peserta_lembaga')->nullable();
            $table->string('b_event_peserta_desc')->nullable();
            $table->string('b_event_peserta_status')->nullable();
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
        Schema::dropIfExists('b_event_peserta');
    }
}
