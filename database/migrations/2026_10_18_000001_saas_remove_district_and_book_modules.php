<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * SaaS pivot: the school is now the tenant. District hierarchy, the book
 * ordering module and the district/supplier/treasurer roles are removed.
 */
return new class extends Migration
{
    private array $legacyRoles = ['Pentadbir', 'Penyelia KAFA', 'Pembekal', 'Bendahari Sekolah'];

    public function up(): void
    {
        Schema::dropIfExists('book_order_items');
        Schema::dropIfExists('book_orders');
        Schema::dropIfExists('books');

        foreach (['users', 'schools', 'announcements', 'activities', 'certificate_templates'] as $table) {
            if (Schema::hasColumn($table, 'district_id')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropConstrainedForeignId('district_id');
                });
            }
        }

        Schema::dropIfExists('districts');

        // The same child may be registered by two different tenants; MyKid is unique per school only.
        Schema::table('students', function (Blueprint $t) {
            $t->dropUnique(['mykid']);
            $t->unique(['school_id', 'mykid']);
        });

        // Transfers are now "pindah keluar": the destination is free text, never another tenant's record.
        Schema::table('student_transfers', function (Blueprint $t) {
            $t->unsignedBigInteger('to_school_id')->nullable()->change();
            $t->string('to_school_name')->nullable()->after('to_school_id');
        });

        if (Schema::hasTable('roles')) {
            $roleIds = DB::table('roles')->whereIn('name', $this->legacyRoles)->pluck('id');
            DB::table('model_has_roles')->whereIn('role_id', $roleIds)->delete();
            DB::table('role_has_permissions')->whereIn('role_id', $roleIds)->delete();
            DB::table('roles')->whereIn('id', $roleIds)->delete();
        }
    }

    public function down(): void
    {
        // One-way migration. Restore from tag v1-jabatan if the district model is needed.
    }
};
