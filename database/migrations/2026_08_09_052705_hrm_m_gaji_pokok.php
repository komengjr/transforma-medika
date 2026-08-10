<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmMGajiPokok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_m_gaji_pokok', function (Blueprint $table) {
            $table->id();
            $table->string('hrm_m_pegawai_code')->unique(); // Foreign Key
            $table->decimal('gaji_pokok', 15, 2)->default(0);

            // Tunjangan Regular
            $table->decimal('tunjangan_jabatan', 15, 2)->default(0);
            $table->decimal('tunjangan_kehadiran', 15, 2)->default(0);
            $table->decimal('tunjangan_makan_transpor', 15, 2)->default(0);
            $table->decimal('tunjangan_kinerja_kpi', 15, 2)->default(0);
            $table->decimal('tunjangan_keluarga', 15, 2)->default(0);
            $table->decimal('tunjangan_lainnya', 15, 2)->default(0);

            // Potongan Standard
            $table->decimal('potongan_bpjs_ks', 15, 2)->default(0);
            $table->decimal('potongan_bpjs_tk', 15, 2)->default(0);
            $table->decimal('potongan_pph21', 15, 2)->default(0);
            $table->decimal('potongan_pinjaman', 15, 2)->default(0);

            $table->string('nomor_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->timestamps();

            // Relasi ke tabel hrm_master_pegawai
            $table->foreign('hrm_m_pegawai_code')
                ->references('hrm_m_pegawai_code')
                ->on('hrm_master_pegawai')
                ->onDelete('cascade');
        });

        Schema::create('hrm_payroll_slip', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_slip')->unique();
            $table->string('hrm_m_pegawai_code');
            $table->string('periode');

            // Snapshot Penghasilan
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('tunjangan_jabatan', 15, 2)->default(0);
            $table->decimal('tunjangan_kehadiran', 15, 2)->default(0);
            $table->decimal('tunjangan_makan_transpor', 15, 2)->default(0);
            $table->decimal('tunjangan_kinerja_kpi', 15, 2)->default(0);
            $table->decimal('tunjangan_keluarga', 15, 2)->default(0);
            $table->decimal('tunjangan_lainnya', 15, 2)->default(0);
            $table->decimal('lembur', 15, 2)->default(0);
            $table->decimal('total_bruto', 15, 2);

            // Snapshot Potongan
            $table->decimal('potongan_bpjs_ks', 15, 2)->default(0);
            $table->decimal('potongan_bpjs_tk', 15, 2)->default(0);
            $table->decimal('potongan_pph21', 15, 2)->default(0);
            $table->decimal('potongan_absensi', 15, 2)->default(0);
            $table->decimal('potongan_pinjaman', 15, 2)->default(0);
            $table->decimal('total_potongan', 15, 2);

            // Take Home Pay
            $table->decimal('gaji_bersih', 15, 2);
            $table->enum('status', ['DRAFT', 'APPROVED', 'PAID'])->default('DRAFT');
            $table->timestamps();

            $table->foreign('hrm_m_pegawai_code')
                ->references('hrm_m_pegawai_code')
                ->on('hrm_master_pegawai')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_m_gaji_pokok');
        Schema::dropIfExists('hrm_payroll_slip');
    }
}
