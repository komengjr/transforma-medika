<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tabel Master / Pertanyaan Survey per Event
        Schema::create('event_surveys', function (Blueprint $table) {
            $table->id('id_event_survey');
            $table->unsignedBigInteger('id_event_data');
            $table->string('question');
            $table->enum('type', ['text', 'rating', 'option'])->default('text');
            $table->json('options')->nullable(); // Untuk menyimpan pilihan jika type = option
            $table->timestamps();
        });

        // 2. Tabel Jawaban Survey dari Peserta
        Schema::create('event_survey_answers', function (Blueprint $table) {
            $table->id('id_survey_answer');
            $table->unsignedBigInteger('id_event_survey');
            $table->unsignedBigInteger('id_participant');
            $table->text('answer');
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
        Schema::dropIfExists('event_survey_answers');
        Schema::dropIfExists('event_surveys');
    }
}
