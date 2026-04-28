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
        Schema::table('schools', function (Blueprint $table) {
            $table->string('code')->nullable(false)->unique()->change();
            $table->string('jenis_premis')->nullable()->after('code');
            $table->string('nama_guru_besar')->nullable()->after('jenis_premis');
            $table->string('no_telefon')->nullable()->after('nama_guru_besar');
            $table->text('alamat')->nullable()->after('no_telefon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->string('code')->nullable()->change();
            $table->dropColumn(['jenis_premis', 'nama_guru_besar', 'no_telefon', 'alamat']);
        });
    }
};
