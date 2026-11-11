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
        Schema::create('medical_registrasi', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();

            // RELASI IDENTITAS & PENJAMIN
            $table->foreignId('pasien_id')->constrained('medical_patient')->onDelete('cascade');
            $table->foreignId('sub_penjamin_id')->nullable()->constrained('medical_sub_penjamin')->onDelete('set null');

            // =================================================================================
            // PEMISAHAN LAYANAN (RAJAL, RANAP, IGD) & POLIKLINIK / RUANGAN
            // =================================================================================
            $table->enum('jenis_layanan', ['RAWAT_JALAN', 'IGD', 'RAWAT_INAP'])
                ->default('RAWAT_JALAN')
                ->comment('Tipe kunjungan pasien');

            $table->foreignId('poli_id')->nullable()
                ->constrained('medical_master_poli')
                ->onDelete('set null')
                ->comment('Diisi ID Poli tujuan (Untuk Rajal / IGD)');

            // UPDATE: Ruangan & Bed untuk Rawat Inap
            $table->foreignId('ruangan_id')->nullable()
                ->constrained('medical_master_ruangan')
                ->onDelete('set null')
                ->comment('Diisi ID Ruangan jika pasien Rawat Inap');

            $table->foreignId('bed_id')->nullable()
                ->constrained('medical_master_bed')
                ->onDelete('set null')
                ->comment('Diisi ID Bed / Tempat Tidur jika pasien Rawat Inap');

            $table->unsignedBigInteger('registrasi_asal_id')->nullable()
                ->comment('Tracking: Jika IGD naik ke Ranap, simpan ID registrasi IGD sebelumnya di sini');

            $table->foreign('registrasi_asal_id')->references('id')->on('medical_registrasi')->onDelete('set null');
            // =================================================================================

            // DATA KLINIS & DOKTER
            $table->integer('tipe_fpp_id')->nullable()->comment('1: Internal, 2: Eksternal');

            // 1. Dokter Pengirim (Rujukan)
            $table->foreignId('doctor_id')->nullable()
                ->constrained('medical_master_doctor')
                ->onDelete('set null')
                ->comment('Referensi ke ID tabel medical_master_doctor (Dokter Pengirim)');

            // 2. TAMBAHAN BARU: Dokter Pemeriksa (Dokter Poli / Jaga IGD / DPJP Rawat Inap)
            $table->foreignId('doctor_poli_id')->nullable()
                ->constrained('medical_master_doctor')
                ->onDelete('set null')
                ->comment('Referensi ke ID dokter yang memeriksa di Poli / IGD / DPJP');

            $table->text('keluhan_medis')->nullable();
            $table->boolean('is_cito')->default(false);

            // LOGISTIK & HASIL
            $table->json('bahasa_hasil')->nullable();
            $table->json('metode_pengiriman')->nullable();
            $table->dateTime('janji_hasil')->nullable();

            // LOG WAKTU & PETUGAS
            $table->string('user_id')->comment('Petugas pendaftaran');
            $table->dateTime('tanggal_registrasi');

            // =================================================================================
            // STATUS KUNJUNGAN & TRACKING VOID / BATAL
            // =================================================================================
            $table->enum('status_kunjungan', ['MENUNGGU', 'PROSES', 'SELESAI', 'BATAL'])->default('MENUNGGU');

            $table->text('alasan_batal')->nullable()->comment('Wajib diisi jika status_kunjungan BATAL');
            $table->string('dibatalkan_oleh')->nullable()->comment('User yang melakukan Void/Batal');
            $table->dateTime('waktu_batal')->nullable();
            // =================================================================================

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('medical_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained('medical_registrasi')->onDelete('cascade');

            $table->decimal('total_tagihan', 15, 2);
            $table->decimal('total_bayar', 15, 2)->default(0);
            $table->decimal('sisa_tagihan', 15, 2)->default(0);
            $table->string('metode_bayar'); // Contoh: Cash, QRIS, EDC, Piutang

            // --- TAMBAHAN BARU UNTUK REFERENSI PEMBAYARAN DIGITAL / EDC ---
            $table->string('edc_id')->nullable()->comment('ID Bank / Mesin EDC yang digunakan');
            $table->string('no_referensi')->nullable()->comment('Menyimpan No Approval EDC, No VA, atau Link/Ref QRIS');
            // -------------------------------------------------------------
            $table->string('dibuat_oleh')->nullable()->after('status_pembayaran')
                ->comment('User ID front office yang memproses transaksi awal');

            // Petugas Keuangan yang melunasi jika status awalnya piutang/belum lunas
            $table->string('dilunasi_oleh')->nullable()->after('dibuat_oleh')
                ->comment('User ID bagian keuangan yang menerima pelunasan piutang');

            $table->dateTime('waktu_lunas')->nullable()->after('dilunasi_oleh')
                ->comment('Waktu ketika piutang dinyatakan lunas oleh keuangan');
            // Status Pembayaran & Refund
            $table->enum('status_pembayaran', ['LUNAS', 'BELUM LUNAS', 'SEBAGIAN', 'REFUND', 'BATAL'])->default('BELUM LUNAS');
            $table->decimal('total_refund', 15, 2)->default(0)->comment('Total uang yang diretur ke pasien');

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('medical_transaksi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('medical_transaksi')->onDelete('cascade');

            // 1. IDENTIFIKASI JENIS ITEM & NAMA UNTUK KASIR
            $table->string('jenis_item')
                ->comment('Kategori: TINDAKAN, OBAT, KAMAR, ADMIN, BMHP');
            $table->string('nama_item')
                ->comment('Nama layanan/obat untuk dicetak di struk kasir tanpa harus join tabel master lagi');

            // 2. REFERENSI SUMBER MASTER (Dibuat Nullable agar fleksibel)
            $table->foreignId('master_pemeriksaan_id')->nullable()
                ->constrained('medical_master_pemeriksaan')
                ->onDelete('set null')
                ->comment('Terisi jika item adalah tindakan medis/lab/rad');

            $table->string('farm_data_obat_code')->nullable()
                ->comment('Terisi jika item adalah obat/farmasi');

            // 3. TRACKING ASAL ORDER (Opsional namun sangat direkomendasikan)
            $table->string('sumber_tagihan')->nullable()
                ->comment('Contoh: POLI_TINDAKAN, POLI_RESEP, IGD_RESEP, RANAP_KAMAR');
            $table->unsignedBigInteger('sumber_id')->nullable()
                ->comment('ID dari tabel sumber (contoh: id dari medical_poli_resep)');

            // 4. PERHITUNGAN BIAYA (Ditambah QTY)
            $table->integer('qty')->default(1);
            $table->decimal('harga_dasar', 15, 2);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->boolean('is_cito')->default(false);
            $table->decimal('biaya_cito', 15, 2)->default(0);

            // harga_akhir = ((harga_dasar - diskon) + biaya_cito) * qty
            $table->decimal('harga_akhir', 15, 2)->comment('Subtotal untuk item ini');

            // 5. STATUS & TRACKING UMUM
            $table->string('no_pemeriksaan')->nullable();
            $table->string('status_pemeriksaan')->default('MENUNGGU')
                ->comment('MENUNGGU, PROSES, SELESAI, BATAL');

            $table->enum('status_pembayaran', ['BELUM LUNAS', 'LUNAS', 'REFUND'])
                ->default('BELUM LUNAS')
                ->comment('Melacak apakah tindakan spesifik ini sudah dibayar kasir');

            $table->dateTime('waktu_bayar')->nullable()
                ->comment('Waktu spesifik item ini dilunasi');

            $table->timestamps();
            $table->softDeletes();
        });
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
        Schema::create('medical_pelunasan_piutang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('medical_transaksi')->onDelete('cascade');

            $table->string('no_pelunasan')->unique()->comment('Contoh: PAY-PIU-20261102-0001');
            $table->decimal('nominal_bayar', 15, 2)->comment('Jumlah nominal yang dibayarkan saat pelunasan');
            $table->string('metode_pembayaran')->comment('CASH, TRANSFER, GIRO, dll');
            $table->string('no_referensi_bank')->nullable()->comment('No bukti transfer / referensi bank');

            $table->text('catatan_pelunasan')->nullable();

            // Track User Keuangan yang menerima uang pelunasan
            $table->string('user_id')->comment('User ID bagian keuangan yang menerima pembayaran');
            $table->dateTime('tanggal_pelunasan');

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
        Schema::dropIfExists('medical_pelunasan_piutang');
    }
}
