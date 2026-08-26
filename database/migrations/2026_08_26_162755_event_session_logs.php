<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventSessionLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_session_logs', function (Blueprint $table) {
            $table->id('id_session_log');

            // Relasi ke event_registration_classes (Presensi per kelas)
            $table->foreignId('id_registration_class')
                ->constrained('event_registration_classes', 'id_registration_class')
                ->onDelete('cascade');

            // Relasi ke event_data_sub_session (Sesi yang dieksekusi)
            $table->foreignId('id_event_data_sub_session')
                ->constrained('event_data_sub_session', 'id_event_data_sub_session')
                ->onDelete('cascade');

            $table->string('qr_code_token'); // Token QR yang discan
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
        Schema::dropIfExists('event_session_logs');
    }
}
