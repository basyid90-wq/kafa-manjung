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
        Schema::create('rph_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kafa_class_id')->constrained('kafa_classes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->integer('week');
            
            $table->string('topic');
            $table->string('topic_jawi')->nullable();
            
            $table->text('learning_standard');
            $table->text('learning_standard_jawi')->nullable();
            
            $table->text('objective');
            $table->text('objective_jawi')->nullable();
            
            $table->text('reflection')->nullable();
            $table->text('reflection_jawi')->nullable();
            
            $table->enum('status', ['pending', 'approved', 'rejected', 'revision_needed'])->default('pending');
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('review_comment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rph_records');
    }
};
