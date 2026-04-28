<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Old single-period content columns are now optional (data lives in rph_periods)
        Schema::table('rph_records', function (Blueprint $table) {
            $table->string('topic')->nullable()->change();
            $table->text('objective')->nullable()->change();
        });

        Schema::create('rph_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rph_id')->constrained('rph_records')->cascadeOnDelete();
            $table->unsignedTinyInteger('period_no'); // 1, 2, 3
            $table->foreignId('kafa_class_id')->nullable()->constrained('kafa_classes')->nullOnDelete();
            $table->string('masa', 60)->nullable();
            $table->string('mata_pelajaran_jawi', 255)->nullable();
            $table->text('topic_jawi')->nullable();
            $table->text('kemahiran_jawi')->nullable();
            $table->text('isi_pelajaran_jawi')->nullable();
            $table->text('objective_jawi')->nullable();
            $table->text('aktiviti_jawi')->nullable();
            $table->text('reflection_jawi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rph_periods');
    }
};
