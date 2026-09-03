<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PhotoboothData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photobooth_data', function (Blueprint $table) {
            $table->id();
            $table->string('org_code')->unique(); // Kode Organisasi
            $table->string('org_name');           // Nama Organisasi
            $table->string('logo_path')->nullable();   // Path Logo
            $table->string('bg_path')->nullable();     // Path Background Tampilan Awal
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('photobooth_data_frame', function (Blueprint $table) {
            $table->id();
            // Foreign key relasi ke master photobooth_data
            $table->foreignId('photobooth_data_id')->constrained('photobooth_data')->onDelete('cascade');
            $table->string('frame_name');  // Nama Frame
            $table->string('frame_path');  // Path Image Frame PNG Transparan
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
        Schema::dropIfExists('photobooth_data');
        Schema::dropIfExists('photobooth_data_frame');
    }
}
