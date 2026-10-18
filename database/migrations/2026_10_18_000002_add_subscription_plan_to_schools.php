<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Each school row is a tenant workspace with a subscription plan.
 * type: personal (one teacher) | sekolah (Guru Besar + teachers)
 * plan: free | personal | sekolah — see config/plans.php
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('type', 20)->default('sekolah')->after('name');
            $table->string('plan', 20)->default('free')->after('type');
            $table->timestamp('plan_expires_at')->nullable()->after('plan');
            $table->foreignId('owner_id')->nullable()->after('plan_expires_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropConstrainedForeignId('owner_id');
            $table->dropColumn(['type', 'plan', 'plan_expires_at']);
        });
    }
};
