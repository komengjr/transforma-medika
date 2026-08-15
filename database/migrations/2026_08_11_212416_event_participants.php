<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id('id_participant');
            $table->string('participant_code')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number', 20);
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('identity_number')->nullable(); // NIK / No. KTP / PASPOR
            $table->string('institution')->nullable(); // Instansi / Perusahaan / Sekolah
            $table->text('address')->nullable();
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
        Schema::dropIfExists('event_participants');
    }
}
