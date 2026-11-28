<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalJurnalUmum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_jurnal_umum', function (Blueprint $table) {
            $table->id();
            $table->string('no_jurnal')->unique();
            $table->date('tanggal_jurnal');
            $table->string('jenis_jurnal', 40)->default('UMUM')
                ->comment('UMUM, PENERIMAAN, PIUTANG, RETUR, PENYESUAIAN');
            $table->string('no_referensi')->nullable()
                ->comment('No registrasi, no kwitansi, no retur, atau no pelunasan piutang');
            $table->unsignedBigInteger('registrasi_id')->nullable();
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->text('keterangan');
            $table->decimal('total_debit', 15, 2)->default(0);
            $table->decimal('total_kredit', 15, 2)->default(0);
            $table->enum('status_jurnal', ['DRAFT', 'POSTED', 'BATAL'])->default('POSTED');
            $table->string('user_id')->nullable();
            $table->string('diposting_oleh')->nullable();
            $table->dateTime('waktu_posting')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tanggal_jurnal', 'status_jurnal']);
            $table->index('no_referensi');
        });

        Schema::create('medical_jurnal_umum_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurnal_umum_id')
                ->constrained('medical_jurnal_umum')
                ->onDelete('cascade');
            $table->string('kode_akun', 30);
            $table->string('nama_akun', 150);
            $table->string('catatan_baris')->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
            $table->timestamps();

            $table->index('kode_akun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_jurnal_umum_detail');
        Schema::dropIfExists('medical_jurnal_umum');
    }
}
