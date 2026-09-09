<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalLoketCounters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_loket_counters', function (Blueprint $table) {
            $table->id();
            $table->json('loket_ids'); // Menyimpan array ID loket, contoh: [1, 2]
            $table->integer('nomor_counter');
            $table->string('ip_address')->unique();
            $table->string('nama_counter')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('medical_loket_counters');
    }
}
