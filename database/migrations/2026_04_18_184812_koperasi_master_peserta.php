<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KoperasiMasterPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_master_peserta', function (Blueprint $table) {
            $table->id('id_kop_master_peserta');
            $table->string('kop_master_peserta_code')->unique();
            $table->string('kop_master_peserta_nik');
            $table->string('kop_master_peserta_nip');
            $table->string('kop_master_peserta_name');
            $table->date('kop_master_peserta_tgl_lahir');
            $table->string('kop_master_peserta_tempat_lahir');
            $table->string('kop_master_peserta_jk');
            $table->string('kop_master_peserta_agama');
            $table->text('kop_master_peserta_alamat');
            $table->string('kop_master_peserta_cabang');
            $table->string('kop_master_peserta_email');
            $table->string('kop_master_peserta_no_hp');
            $table->date('kop_master_peserta_tgl_kerja');
            $table->date('kop_master_peserta_tgl_anggota');
            $table->text('kop_master_peserta_photo')->nullable();
            $table->string('kop_master_peserta_status');
            $table->string('security_code', 6)->default('123456')->after('password');
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
        Schema::dropIfExists('kop_master_peserta');
    }
}
