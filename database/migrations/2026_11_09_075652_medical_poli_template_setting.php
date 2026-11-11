<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalPoliTemplateSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_poli_template_setting', function (Blueprint $table) {
            $table->id();

            // Relasi ke Master Poli
            $table->foreignId('poli_id')
                ->constrained('medical_master_poli')
                ->onDelete('cascade');

            // Jenis Template Form yang akan dirender di halaman handling
            $table->enum('jenis_template', [
                'UMUM',
                'GIGI',
                'KANDUNGAN',
                'MATA',
                'THT',
                'KULIT_KELAMIN',
                'CUSTOM'
            ])->default('UMUM')->comment('Menentukan form apa yang di-load saat handling pasien');

            $table->text('keterangan')->nullable()->comment('Deskripsi instruksi atau catatan khusus untuk form poli');
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Mencegah 1 poli memiliki lebih dari 1 setting template ganda
            $table->unique('poli_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_poli_template_setting');
    }
}
