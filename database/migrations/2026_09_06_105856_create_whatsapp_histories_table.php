<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_whatsapp_histories', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->nullable()->index(); // ID Unik Batch Pengiriman
            $table->string('recipient'); // Nomor WA Penerima
            $table->string('subject'); // Subjek / Judul Pesan
            $table->text('message'); // Isi Pesan
            $table->string('attachment')->nullable(); // Nama File Lampiran
            $table->enum('status', ['pending', 'processing', 'success', 'failed'])->default('pending'); // Status
            $table->text('error_message')->nullable(); // Pesan Error jika gagal
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
        Schema::dropIfExists('b_whatsapp_histories');
    }
}
