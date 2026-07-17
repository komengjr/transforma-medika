<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KopPencairanArisan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_pencairan_arisan', function (Blueprint $table) {
            $table->id('id_kop_pencairan_arisan');
            $table->unsignedBigInteger('id_kop_master_arisan');
            $table->unsignedBigInteger('id_kop_master_peserta');
            $table->integer('kop_pencairan_bulan');
            $table->integer('kop_pencairan_tahun');
            $table->decimal('kop_pencairan_nominal', 15, 2);
            $table->dateTime('kop_pencairan_tanggal');
            $table->string('kop_pencairan_status')->default('Cair'); // Cair, Pending
            $table->text('kop_pencairan_keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_kop_master_arisan')->references('id_kop_master_arisan')->on('kop_master_arisan')->onDelete('cascade');
            $table->foreign('id_kop_master_peserta')->references('id_kop_master_peserta')->on('kop_master_peserta')->onDelete('cascade');

            // Satu orang hanya bisa mencairkan sekali di bulan & tahun plot jadwalnya
            $table->unique(['id_kop_master_arisan', 'id_kop_master_peserta', 'kop_pencairan_bulan', 'kop_pencairan_tahun'], 'idx_unique_pencairan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_pencairan_arisan');
    }
}
