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
        // 1. Jadual users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'school_id')) {
                $table->foreignId('school_id')->nullable()->after('district_id')->constrained()->onDelete('set null');
            }
        });

        // 2. Jadual kafa_classes
        Schema::table('kafa_classes', function (Blueprint $table) {
            if (!Schema::hasColumn('kafa_classes', 'school_id')) {
                $table->foreignId('school_id')->after('id')->constrained()->cascadeOnDelete();
            }
        });

        // 3. Jadual students
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'school_id')) {
                $table->foreignId('school_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Biasanya kita tidak buang kolum jika ia sudah wujud sebelumnya, 
        // tapi dalam konteks migration ini kita biarkan kosong atau 
        // buang jika kita pasti ia baru ditambah.
    }
};
