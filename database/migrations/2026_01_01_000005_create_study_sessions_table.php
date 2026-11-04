<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->nullOnDelete();
            $table->date('session_date')->index();
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->enum('attendance_status', ['Hadir', 'Izin', 'Sakit', 'Alpha'])->default('Hadir');
            $table->enum('subject_category', ['Jarimatika', 'Matematika', 'Fisika', 'Kimia', 'Biologi', 'Strategi Soal', 'Persiapan Ujian'])->nullable();
            $table->string('topic_covered')->nullable();
            $table->unsignedTinyInteger('speed_rating')->nullable();
            $table->unsignedTinyInteger('practice_score')->nullable();
            $table->text('tutor_notes')->nullable();
            $table->boolean('wa_arrival_sent')->default(false);
            $table->boolean('wa_report_sent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_sessions');
    }
};
