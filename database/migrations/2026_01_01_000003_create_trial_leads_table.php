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
        Schema::create('trial_leads', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('whatsapp');
            $table->string('student_name');
            $table->enum('grade_level', ['TK', 'SD', 'SMP']);
            $table->string('school_name')->nullable();
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->nullOnDelete();
            $table->string('learning_obstacle')->nullable();
            $table->unsignedTinyInteger('quiz_score')->nullable();
            $table->decimal('quiz_avg_time', 4, 1)->nullable();
            $table->enum('status', ['Baru', 'Dihubungi', 'Sudah Trial', 'Daftar Resmi', 'Batal'])->default('Baru');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trial_leads');
    }
};

