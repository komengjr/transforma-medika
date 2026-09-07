<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventDataSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_data_sends', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('phone_number');
            $table->text('message')->nullable();
            $table->longText('attachment_base64')->nullable();
            $table->string('attachment_mimetype')->nullable();
            $table->string('attachment_filename')->nullable();
            $table->enum('status', ['pending', 'processing', 'sent', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            // Indexing agar query polling dari Node.js cepat
            $table->index(['status', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_data_sends');
    }
}
