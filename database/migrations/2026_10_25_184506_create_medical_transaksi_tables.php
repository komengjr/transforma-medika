<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalTransaksiTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tabel Kunjungan / Registrasi (BARU)
        Schema::create('medical_registrasi', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->foreignId('pasien_id')->constrained('medical_patient')->onDelete('cascade');
            $table->foreignId('sub_penjamin_id')->nullable()->constrained('medical_sub_penjamin')->onDelete('set null');

            $table->integer('tipe_fpp_id')->nullable()->comment('1: Internal, 2: Eksternal');
            $table->string('dokter')->nullable();

            $table->json('bahasa_hasil')->nullable();
            $table->json('metode_pengiriman')->nullable();
            $table->dateTime('janji_hasil')->nullable();

            $table->boolean('is_cito')->default(false);
            $table->string('user_id');
            $table->dateTime('tanggal_registrasi');

            // --- UPDATE DI SINI ---
            // Ubah tipe data status_kunjungan agar mencakup status BATAL
            $table->enum('status_kunjungan', ['MENUNGGU', 'PROSES', 'SELESAI', 'BATAL'])->default('MENUNGGU');

            // Tambahan untuk tracking VOID
            $table->text('alasan_batal')->nullable()->comment('Alasan kenapa pasien batal/void');
            $table->string('dibatalkan_oleh')->nullable()->comment('User ID yang melakukan void');
            $table->dateTime('waktu_batal')->nullable();
            // ----------------------

            $table->text('keluhan_medis')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Disarankan pakai soft delete agar data tidak hilang dari database
        });

        // 2. Tabel Utama Transaksi (UPDATE: Terikat ke medical_registrasi)
        Schema::create('medical_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');

            $table->decimal('total_tagihan', 15, 2);
            $table->decimal('total_bayar', 15, 2)->default(0);
            $table->decimal('sisa_tagihan', 15, 2)->default(0);
            $table->string('metode_bayar');

            // --- UPDATE DI SINI ---
            // Tambahkan status REFUND dan BATAL
            $table->enum('status_pembayaran', ['LUNAS', 'BELUM LUNAS', 'SEBAGIAN', 'REFUND', 'BATAL'])->default('BELUM LUNAS');

            // Track jumlah uang yang dikembalikan ke pasien
            $table->decimal('total_refund', 15, 2)->default(0)->comment('Total uang yang diretur ke pasien');
            // ----------------------

            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Tabel Detail Item Transaksi (List Pemeriksaan / Order)
        Schema::create('medical_transaksi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('medical_transaksi')->onDelete('cascade');
            $table->foreignId('master_pemeriksaan_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');
            $table->string('no_pemeriksaan')->nullable();

            $table->decimal('harga_dasar', 15, 2);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->boolean('is_cito')->default(false);
            $table->decimal('biaya_cito', 15, 2)->default(0);
            $table->decimal('harga_akhir', 15, 2);

            // --- UPDATE DI SINI ---
            // Tambahkan status BATAL
            $table->string('status_pemeriksaan')->default('MENUNGGU')->comment('MENUNGGU, PROSES, SELESAI, BATAL');
            // ----------------------

            $table->timestamps();
            $table->softDeletes();
        });
        // Tabel khusus mencatat aliran dana keluar karena Void / Retur
        Schema::create('medical_transaksi_retur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('medical_transaksi')->onDelete('cascade');

            $table->string('no_retur')->unique()->comment('Contoh: RET-20261026-0001');
            $table->decimal('nominal_retur', 15, 2)->comment('Jumlah uang yang dikembalikan');
            $table->string('metode_retur')->comment('CASH, TRANSFER BANK, dll');
            $table->string('rekening_tujuan')->nullable()->comment('Jika retur via transfer');

            $table->text('alasan_retur');
            $table->string('user_id')->comment('Petugas yang melakukan retur uang');
            $table->string('disetujui_oleh')->nullable()->comment('Manajer/SPV yang approve retur');

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
        Schema::dropIfExists('medical_registrasi');
        Schema::dropIfExists('medical_transaksi');
        Schema::dropIfExists('medical_transaksi_detail');
        Schema::dropIfExists('medical_transaksi_retur');
    }
}
