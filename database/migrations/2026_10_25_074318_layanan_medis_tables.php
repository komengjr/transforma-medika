<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LayananMedisTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_penjamin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penjamin');
            $table->string('jenis_kategori')->nullable()->comment('Contoh: Asuransi, Perusahaan, BPJS, Mandiri');
            $table->timestamps();
        });
        Schema::create('medical_sub_penjamin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjamin_id')->constrained('medical_penjamin')->onDelete('cascade');
            $table->string('nama_sub_penjamin');

            // --- IDENTITAS & KONTRAK ---
            $table->string('no_ref')->nullable()->comment('No Kontrak / SPK / MoU');
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->text('catatan_pelayanan')->nullable();

            // --- PENGATURAN PEMBAYARAN & KEUANGAN ---
            $table->string('tipe_pembayaran')->default('CASH_DI_AWAL')
                ->comment('CASH_DI_AWAL, CORPORATE_BILLING, INSURANCE_CLAIM');
            $table->integer('jatuh_tempo_hari')->default(30);
            $table->decimal('min_dp_persen', 5, 2)->default(0.00);

            // --- SKEMA SPLIT BILLING & TANGGUNGAN (COVERAGE RULE) ---
            $table->string('pola_tanggungan')->default('FULL_PASIEN')
                ->comment('FULL_PASIEN, FULL_PERUSAHAAN, SPLIT_PERSENTASE, SPLIT_PLAFON');
            $table->decimal('tanggungan_perusahaan_persen', 5, 2)->default(0.00);
            $table->decimal('tanggungan_perusahaan_maksimal_rp', 15, 2)->default(0.00);

            // --- KONTAK & ALAMAT UTAMA ---
            $table->text('alamat')->nullable();
            $table->string('telp_perusahaan')->nullable();

            // --- SYARAT & KETENTUAN KHUSUS ---
            $table->boolean('wajib_surat_garansi')->default(false)
                ->comment('1 = Wajib melampirkan Surat Garansi / LoG');

            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
        Schema::create('medical_sub_penjamin_pics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_penjamin_id')->constrained('medical_sub_penjamin')->onDelete('cascade');
            $table->string('nama_pic')->comment('Nama lengkap PIC');
            $table->string('jabatan')->nullable()->comment('Contoh: Kepala Keuangan, Staf Klaim');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_primary')->default(false)->comment('1 = PIC Utama / Kontak Darurat Utama');
            $table->timestamps();
        });
        Schema::create('medical_tipe_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tipe'); // Contoh: Laboratorium, Radiologi, Fisioterapi
            $table->string('prefix', 5)->comment('Contoh: LAB, RAD, FIS');
            $table->boolean('is_active')->default(true)->comment('Status aktif/nonaktif');
            $table->timestamps();
        });
        Schema::create('medical_master_pemeriksaan', function (Blueprint $table) {
            $table->id();
            // Relasi ke tipe layanan (sub_penjamin_id dihilangkan dari master)
            $table->foreignId('tipe_layanan_id')->constrained('medical_tipe_layanan')->onDelete('cascade');

            // Mencegah duplikasi kode layanan
            $table->string('kode_layanan')->unique();
            $table->string('nama_layanan');
            $table->text('deskripsi')->nullable()->comment('Opsional: Penjelasan persiapan pasien, misal: Puasa 10 Jam');

            // --- [REKOMENDASI TAMBAHAN] ---
            // 1. Integrasi & Operasional Radiologi/Lab
            $table->string('modality_code', 10)->nullable()->comment('Kode DICOM Modality (CR, DX, CT, US, MR, dll)');
            $table->string('jenis_sampel')->nullable()->comment('Khusus Lab: Darah EDTA, Urine, Serum, dll');

            // 2. Manajemen Antrean & Medikolegal
            $table->integer('estimasi_waktu_menit')->default(15)->comment('Estimasi lama tindakan/pemeriksaan');
            $table->boolean('is_consent_required')->default(false)->comment('Butuh TTD Informed Consent? (Misal: CT Kontras)');
            // ------------------------------

            // Pricing
            $table->decimal('harga', 15, 2); // Harga dasar (Master Price)

            $table->boolean('is_paket')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('medical_paket_detail', function (Blueprint $table) {
            $table->id();
            // ID Paket (Mengambil dari tabel master pemeriksaan yang is_paket = true)
            $table->foreignId('paket_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');

            // ID Pemeriksaan di dalam paket (Mengambil dari tabel master pemeriksaan)
            $table->foreignId('pemeriksaan_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');

            $table->timestamps();
        });
        Schema::create('medical_penjamin_pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_penjamin_id')->constrained('medical_sub_penjamin')->onDelete('cascade');
            $table->foreignId('master_pemeriksaan_id')->constrained('medical_master_pemeriksaan')->onDelete('cascade');

            // Field Diskon (Nominal potongan harga spesifik untuk sub penjamin ini)
            $table->decimal('diskon', 15, 2)->default(0);

            // Opsional: Jika diskon berupa persen, Anda bisa menggunakan ini juga:
            // $table->decimal('persentase_diskon', 5, 2)->default(0);

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
        Schema::dropIfExists('medical_penjamin_pemeriksaan');
        Schema::dropIfExists('medical_master_pemeriksaan');
        Schema::dropIfExists('medical_tipe_layanan');
        Schema::dropIfExists('medical_sub_penjamin');
        Schema::dropIfExists('medical_sub_penjamin_pics');
        Schema::dropIfExists('medical_penjamin');
        Schema::dropIfExists('medical_paket_detail');
    }
}
