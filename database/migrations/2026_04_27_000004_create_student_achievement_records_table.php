<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_achievement_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kafa_class_id')->constrained('kafa_classes')->cascadeOnDelete();
            $table->year('academic_year');

            // Link to exams for mid-year and end-year
            $table->foreignId('midyear_exam_id')->nullable()->constrained('exams')->nullOnDelete();
            $table->foreignId('endyear_exam_id')->nullable()->constrained('exams')->nullOnDelete();

            // PHCI — teacher behavioural assessment (not in exam_results)
            $table->unsignedTinyInteger('phci_midyear')->nullable();
            $table->unsignedTinyInteger('phci_endyear')->nullable();

            // Behavioural assessments
            $table->enum('kelakuan', ['A', 'B', 'C', 'D'])->nullable();
            $table->enum('kebersihan', ['A', 'B', 'C', 'D'])->nullable();

            // Rankings (computed at generation time)
            $table->unsignedSmallInteger('class_rank')->nullable();
            $table->unsignedSmallInteger('grade_rank')->nullable();
            $table->unsignedSmallInteger('total_in_class')->nullable();
            $table->unsignedSmallInteger('total_in_grade')->nullable();

            $table->text('teacher_comments')->nullable();
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'final'])->default('draft');

            $table->timestamps();

            $table->unique(['student_id', 'academic_year'], 'unique_student_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_achievement_records');
    }
};
