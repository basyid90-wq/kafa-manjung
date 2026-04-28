<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            // Jadikan school_id nullable (aktiviti daerah/negeri tiada school_id)
            $table->foreignId('school_id')->nullable()->change();

            // Tambah district_id nullable (diisi untuk tahap daerah & negeri)
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete()->after('school_id');

            // Tahap aktiviti
            $table->enum('tahap', ['sekolah', 'daerah', 'negeri'])->default('sekolah')->after('district_id');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->dropColumn(['district_id', 'tahap']);
            $table->foreignId('school_id')->nullable(false)->change();
        });
    }
};
