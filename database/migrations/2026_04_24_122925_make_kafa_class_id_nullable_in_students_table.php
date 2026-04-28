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
        Schema::table('students', function (Blueprint $table) {
            // Drop the existing non-nullable FK, then re-add as nullable
            $table->dropForeign(['kafa_class_id']);
            $table->foreignId('kafa_class_id')->nullable()->change();
            $table->foreign('kafa_class_id')->references('id')->on('kafa_classes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['kafa_class_id']);
            $table->foreignId('kafa_class_id')->nullable(false)->change();
            $table->foreign('kafa_class_id')->references('id')->on('kafa_classes')->cascadeOnDelete();
        });
    }
};
