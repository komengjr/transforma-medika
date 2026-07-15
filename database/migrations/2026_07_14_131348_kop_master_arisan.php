<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopMasterArisan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_arisan', function (Blueprint $table) {
            $table->id('id_kop_master_arisan');
            $table->string('kop_master_arisan_code')->unique(); // Contoh: ARS-2026
            $table->string('kop_master_arisan_name');          // Contoh: Arisan Sejahtera Dekade I
            $table->decimal('kop_master_arisan_nominal_point', 15, 2); // Nilai Rupiah per 1 Poin (misal: 50000.00)
            $table->year('kop_master_arisan_thn_mulai');       // Tahun mulai (misal: 2026)
            $table->year('kop_master_arisan_thn_selesai');     // Tahun selesai (misal: 2035 untuk 1 dekade)
            $table->enum('kop_master_arisan_status', ['Aktif', 'Selesai', 'Draft'])->default('Aktif');
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
        Schema::dropIfExists('kop_master_arisan');
    }
}
