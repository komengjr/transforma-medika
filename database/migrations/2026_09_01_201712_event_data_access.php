<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventDataAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_data_access', function (Blueprint $table) {
            $table->id('id_event_data_access');

            // Relasi ke tabel event_data
            $table->unsignedBigInteger('event_data_id');
            $table->foreign('event_data_id')
                ->references('id_event_data')
                ->on('event_data')
                ->onDelete('cascade');

            // ID User disesuaikan jadi userid
            $table->string('userid');

            // Role/akses user di event ini (misal: 'admin', 'operator')
            $table->string('role')->default('operator');

            // Status akses (1 = aktif, 0 = nonaktif)
            $table->tinyInteger('status')->default(1);

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
        Schema::dropIfExists('event_data_access');
    }
}
