<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccJurnal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_jurnal', function (Blueprint $table) {
            $table->id('id_acc_jurnal');
            $table->string('acc_jurnal_no')->unique(); // Contoh: ACC-202611-0001
            $table->string('source_project', 100);       // Contoh: 'koperasi', 'mcu', 'apotek'
            $table->string('source_table', 100);         // Contoh: 'kop_fin_jurnal'
            $table->string('source_jurnal_id', 100);     // ID/kode jurnal asal (misal: id_jurnal = 7)
            $table->string('jurnal_no_bukti', 100)->nullable();
            $table->date('jurnal_tgl');
            $table->text('jurnal_keterangan')->nullable();
            $table->string('jurnal_ref_table', 100)->nullable();
            $table->string('jurnal_ref_code', 100)->nullable();
            $table->string('jurnal_cabang', 100)->nullable();
            $table->string('jurnal_user', 100)->nullable();
            $table->string('status_posting', 20)->default('posted'); // posted
            $table->timestamp('posted_at')->nullable();
            $table->string('posted_by', 100)->nullable();
            $table->timestamps();

            $table->index(['source_project', 'source_jurnal_id'], 'idx_acc_jurnal_source');
            $table->index('jurnal_tgl', 'idx_acc_jurnal_tgl');
        });

        Schema::create('acc_jurnal_detail', function (Blueprint $table) {
            $table->id('id_acc_jurnal_detail');
            $table->foreignId('acc_jurnal_id')
                ->constrained('acc_jurnal', 'id_acc_jurnal')
                ->onDelete('cascade');
            $table->string('coa_code', 50);
            $table->string('coa_name', 190)->nullable();
            $table->string('coa_type', 50)->nullable();
            $table->bigInteger('jurnal_debit')->default(0);
            $table->bigInteger('jurnal_kredit')->default(0);
            $table->timestamps();

            $table->index('coa_code', 'idx_acc_jurnal_detail_coa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_jurnal_detail');
        Schema::dropIfExists('acc_jurnal');
    }
}
