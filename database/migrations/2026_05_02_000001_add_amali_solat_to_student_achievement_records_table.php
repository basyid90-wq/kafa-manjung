<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_achievement_records', function (Blueprint $table) {
            $table->enum('amali_solat', ['Lulus', 'Tidak Lulus'])->nullable()->after('kebersihan');
        });
    }

    public function down(): void
    {
        Schema::table('student_achievement_records', function (Blueprint $table) {
            $table->dropColumn('amali_solat');
        });
    }
};
