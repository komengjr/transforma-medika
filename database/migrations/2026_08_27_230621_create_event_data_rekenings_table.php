<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventDataRekeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_data_rekening', function (Blueprint $table) {
            $table->id('id_event_data_rekening');

            // Kode Event sebagai relasi utama
            $table->string('event_data_code', 50);

            // Detail Rekening
            $table->string('bank_name', 50);         // Contoh: BCA, Mandiri, BRI, Bank Jago
            $table->string('account_number', 50);    // Nomor Rekening / E-Wallet (OVO/Gopay/DANA)
            $table->string('account_holder', 100);   // Nama Pemilik Rekening (Atas Nama / a.n.)
            $table->string('bank_branch', 100)->nullable(); // Kantor Cabang (Opsional)

            // Status & Catatan
            $table->boolean('is_active')->default(true); // Status aktif/non-aktifkan rekening
            $table->text('notes')->nullable();          // Catatan khusus (Contoh: "Transfer hingga 3 digit terakhir")

            $table->timestamps();

            // Indexing & Foreign Key Relationship
            $table->index('event_data_code');
            $table->foreign('event_data_code')
                ->references('event_data_code')
                ->on('event_data')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::create('event_data_contact', function (Blueprint $table) {
            $table->id('id_event_data_contact');

            // Kode Event sebagai relasi utama
            $table->string('event_data_code', 50);

            // Detail Contact Person
            $table->string('contact_name', 100);      // Nama Panitia / PIC
            $table->string('contact_role', 50)->nullable(); // Jabatan (Contoh: "Humas", "Konfirmasi Pembayaran")
            $table->string('contact_number', 20);     // Nomor Telp/WhatsApp (Format: 08xx / 628xx)
            $table->string('contact_email', 100)->nullable(); // Email Panitia (Opsional)

            // Status & Urutan
            $table->boolean('is_active')->default(true); // Status tampil/sembunyi
            $table->integer('sort_order')->default(0);  // Untuk mengatur urutan posisi CP

            $table->timestamps();

            // Indexing & Foreign Key Relationship
            $table->index('event_data_code');
            $table->foreign('event_data_code')
                ->references('event_data_code')
                ->on('event_data')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_data_rekening');
        Schema::dropIfExists('event_data_contact');
    }
}
