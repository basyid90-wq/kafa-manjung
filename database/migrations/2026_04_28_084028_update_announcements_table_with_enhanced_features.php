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
        Schema::table('announcements', function (Blueprint $table) {
            // Add category column if not exists (with nullable for backward compatibility)
            if (!Schema::hasColumn('announcements', 'category')) {
                $table->string('category')->nullable()->after('title');
            }

            // Enhanced targeting fields
            $table->string('target_role')->nullable()->after('is_global')->comment('Role yang disasarkan: Penyelia KAFA, Pembekal, Guru Besar, dll');
            $table->enum('target_scope', ['all', 'district', 'school', 'specific'])->default('all')->after('target_role');

            // Homepage announcement fields (Super Admin only)
            $table->boolean('is_homepage')->default(false)->after('is_global')->comment('Hebahan untuk login page');
            $table->enum('homepage_label', ['Ciri Baharu', 'Pembaikan', 'Penyelenggaraan', 'Kritikal', 'Pengumuman'])->nullable()->after('is_homepage');
            $table->timestamp('expires_at')->nullable()->after('homepage_label')->comment('Auto hide date untuk homepage announcement');

            // Soft deletes
            $table->softDeletes();

            // Add indexes for performance
            $table->index('is_homepage');
            $table->index('target_role');
            $table->index('target_scope');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn([
                'target_role',
                'target_scope',
                'is_homepage',
                'homepage_label',
                'expires_at',
                'deleted_at'
            ]);
        });
    }
};
