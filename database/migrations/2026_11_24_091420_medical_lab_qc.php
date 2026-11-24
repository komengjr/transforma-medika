<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalLabQc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_lab_qc_materials', function (Blueprint $table) {
            $table->id();
            $table->string('kode_material', 50)->unique();
            $table->string('nama_material', 150);
            $table->string('lot_number', 100);
            $table->unsignedBigInteger('instrument_id')->nullable();
            $table->string('nama_alat', 150)->nullable();
            $table->date('tanggal_expired')->nullable();
            $table->enum('status', ['AKTIF', 'NONAKTIF', 'EXPIRED'])->default('AKTIF');
            $table->timestamps();

            if (Schema::hasTable('medical_master_alat')) {
                $table->foreign('instrument_id', 'fk_qc_material_instrument')
                    ->references('instrument_id')
                    ->on('medical_master_alat')
                    ->nullOnDelete();
            }
        });
        Schema::create('medical_lab_qc_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qc_material_id')
                ->constrained('medical_lab_qc_materials')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('master_pemeriksaan_id')->nullable();
            $table->string('nama_parameter', 150);
            $table->string('satuan', 50)->nullable();
            $table->string('metode', 100)->nullable();
            $table->decimal('target_mean', 12, 4);
            $table->decimal('target_sd', 12, 4);
            $table->decimal('batas_bawah', 12, 4)->nullable();
            $table->decimal('batas_atas', 12, 4)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            if (Schema::hasTable('medical_master_pemeriksaan')) {
                $table->foreign('master_pemeriksaan_id', 'fk_qc_param_master_pemeriksaan')
                    ->references('id')
                    ->on('medical_master_pemeriksaan')
                    ->nullOnDelete();
            }
        });
        Schema::create('medical_lab_qc_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qc_material_id')
                ->constrained('medical_lab_qc_materials')
                ->cascadeOnDelete();
            $table->foreignId('qc_parameter_id')
                ->constrained('medical_lab_qc_parameters')
                ->cascadeOnDelete();
            $table->date('tanggal_qc');
            $table->time('jam_qc');
            $table->decimal('nilai_hasil', 12, 4);
            $table->decimal('z_score', 8, 3)->nullable();
            $table->enum('status_qc', ['IN_CONTROL', 'WARNING_2SD', 'OUT_OF_CONTROL'])->default('IN_CONTROL');
            $table->string('rule_triggered', 50)->nullable();
            $table->text('catatan_tindakan')->nullable();
            $table->string('petugas_qc', 120)->nullable();
            $table->enum('status_review', ['MENUNGGU', 'DISETUJUI', 'DITOLAK'])->default('MENUNGGU');
            $table->string('verified_by', 120)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index('tanggal_qc');
            $table->index('status_qc');
        });
        Schema::create('medical_lab_qc_incoming', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instrument_id')->nullable()->index();
            $table->string('nolab', 100)->nullable();
            $table->timestamp('tanggal_alat')->nullable();
            $table->longText('payload_json');
            $table->enum('status', ['PENDING', 'PROCESSED', 'IGNORED'])->default('PENDING')->index();
            $table->timestamp('processed_at')->nullable();
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
        Schema::dropIfExists('medical_lab_qc_logs');
        Schema::dropIfExists('medical_lab_qc_parameters');
        Schema::dropIfExists('medical_lab_qc_materials');
        Schema::dropIfExists('medical_lab_qc_incoming');
    }
}
