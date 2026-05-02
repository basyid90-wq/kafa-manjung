<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('module');          // pilihan modul dropdown
            $table->text('description');       // penerangan masalah
            $table->string('image_path')->nullable();  // tangkapan skrin (optional)
            $table->enum('status', ['baru', 'dalam_semakan', 'selesai'])->default('baru');
            $table->text('admin_reply')->nullable();   // balasan Super Admin
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
