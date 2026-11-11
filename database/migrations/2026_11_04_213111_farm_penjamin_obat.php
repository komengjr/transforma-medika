<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FarmPenjaminObat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_penjamin_obat', function (Blueprint $table) {
            $table->id();
            $table->string('farm_data_obat_code');
            $table->unsignedBigInteger('penjamin_id');
            $table->unsignedBigInteger('sub_penjamin_id');
            $table->decimal('harga_jual', 12, 2)->default(0);
            $table->tinyInteger('status')->default(1)->comment('1 = Aktif, 0 = Non-Aktif'); // Kolom status baru
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('sub_penjamin_id')->references('id')->on('medical_sub_penjamin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farm_penjamin_obat');
    }
}
