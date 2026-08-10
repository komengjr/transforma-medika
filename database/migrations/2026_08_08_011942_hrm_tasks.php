<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrmTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_tasks', function (Blueprint $table) {
            $table->id('id_hrm_tasks');
            $table->string('task_code', 50)->unique();
            $table->string('task_title');
            $table->text('task_description')->nullable();

            // Pengirim & Penerima Tugas
            $table->string('created_by_pegawai_code', 50);
            $table->string('assigned_pegawai_code', 50);
            $table->string('hrm_departemen_code', 50)->nullable();

            // Kategori & Prioritas
            $table->enum('task_category', ['routine', 'project', 'work_order', 'urgent'])->default('routine');
            $table->enum('task_priority', ['low', 'medium', 'high', 'urgent'])->default('medium');

            // Estimasi & Tracking Waktu
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->dateTime('completed_at')->nullable();

            // Progress & Status
            $table->unsignedTinyInteger('task_progress')->default(0); // 0-100%
            $table->enum('status', ['pending', 'in_progress', 'review', 'completed', 'cancelled'])->default('pending');

            // Lampiran & Approval
            $table->string('attachment_file')->nullable();
            $table->string('reviewed_by_pegawai_code', 50)->nullable();
            $table->text('review_notes')->nullable();

            $table->timestamps();

            // Indexing untuk performa fungsi KPI calculateSystemScore
            $table->index(['assigned_pegawai_code', 'status']);
            $table->index(['assigned_pegawai_code', 'completed_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_tasks');
    }
}
