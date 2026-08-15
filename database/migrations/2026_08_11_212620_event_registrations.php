<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventRegistrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id('id_registration');
            $table->string('registration_code')->unique(); // e.g. REG-20260811-0001

            // Relasi ke Peserta dan Event
            $table->foreignId('id_participant')->constrained('event_participants', 'id_participant')->onDelete('cascade');
            $table->foreignId('id_event_data')->constrained('event_data', 'id_event_data')->onDelete('cascade');

            $table->decimal('total_amount', 12, 2)->default(0);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('email_sent_at')->nullable();
            $table->enum('registration_status', ['active', 'cancelled'])->default('active');
            $table->dateTime('registration_date');
            $table->timestamps();
        });
        Schema::create('event_registration_classes', function (Blueprint $table) {
            $table->id('id_registration_class');

            // Mengikat ke transaksi pendaftaran dan kelas spesifik
            $table->foreignId('id_registration')->constrained('event_registrations', 'id_registration')->onDelete('cascade');
            $table->foreignId('id_event_data_sub_class')->constrained('event_data_sub_class', 'id_event_data_sub_class')->onDelete('cascade');

            $table->bigInteger('price'); // Harga kelas saat dibeli ( snapshot harga )
            $table->enum('attendance_status', ['registered', 'present', 'absent'])->default('registered');
            $table->dateTime('check_in_at')->nullable(); // Pencatatan absensi peserta di kelas
            $table->string('qr_code_token')->nullable(); // Token/QR untuk presensi masuk kelas

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
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('event_registration_classes');
    }
}
