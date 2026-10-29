<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalPasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_patient', function (Blueprint $table) {
            $table->id();
            $table->string('pid')->unique(); // Contoh: P-1002
            $table->string('awalan')->nullable();
            $table->string('nama');
            $table->string('akhiran')->nullable();
            $table->enum('jk', ['L', 'P']);
            $table->string('title');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->integer('umur')->nullable();
            $table->string('agama')->nullable();
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('nip')->nullable();
            $table->string('tipe_id')->nullable();
            $table->string('no_id')->nullable(); // NIK KTP / SIM
            $table->text('catatan')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->text('alamat');
            $table->longText('foto')->nullable(); // Menyimpan base64 foto
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
        Schema::dropIfExists('medical_patient');
    }
}
