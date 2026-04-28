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
        Schema::table('kafa_classes', function (Blueprint $table) {
            $table->string('tahun')->after('school_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kafa_classes', function (Blueprint $table) {
            $table->dropColumn('tahun');
        });
    }
};
