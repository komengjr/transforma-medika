<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmKomponenGaji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 2. Tabel Master Komponen Gaji (Bisa ditambah sewaktu-waktu)
        Schema::create('hrm_komponen_gaji', function (Blueprint $table) {
            $table->id('id_komponen');
            $table->string('kode_komponen')->unique(); // contoh: GP, UM, UT, T_KESH
            $table->string('nama_komponen');          // contoh: Gaji Pokok, Uang Makan, Uang Transport
            $table->enum('tipe', ['pendapatan', 'potongan']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Tabel Setting Nominal Komponen per Departemen
        Schema::create('hrm_departemen_komponen', function (Blueprint $table) {
            $table->id();
            $table->string('hrm_departemen_code');
            $table->unsignedBigInteger('id_komponen');
            $table->decimal('nominal_default', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('hrm_departemen_code')
                ->references('hrm_departemen_code')
                ->on('hrm_departemen')
                ->onDelete('cascade');

            $table->foreign('id_komponen')
                ->references('id_komponen')
                ->on('hrm_komponen_gaji')
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
        Schema::dropIfExists('hrm_komponen_gaji');
        Schema::dropIfExists('hrm_departemen_komponen');
    }
}
