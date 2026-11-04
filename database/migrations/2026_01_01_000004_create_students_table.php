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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code')->unique();
            $table->string('portal_token')->unique()->index();
            $table->string('full_name');
            $table->string('nickname')->nullable();
            $table->enum('grade_level', ['TK', 'SD', 'SMP']);
            $table->string('class_number')->nullable();
            $table->string('school_name')->nullable();
            $table->string('parent_name');
            $table->string('parent_whatsapp');
            $table->text('address')->nullable();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->unsignedTinyInteger('jarimatika_level')->default(1);
            $table->unsignedTinyInteger('mipa_mastery_percent')->default(20);
            $table->date('join_date');
            $table->enum('status', ['Aktif', 'Cuti', 'Lulus'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
