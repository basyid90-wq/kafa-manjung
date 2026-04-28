<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rph_records', function (Blueprint $table) {
            $table->string('hari')->nullable()->after('week');
            $table->string('masa')->nullable()->after('hari');
            $table->string('mata_pelajaran')->nullable()->after('masa');
            $table->string('mata_pelajaran_jawi')->nullable()->after('mata_pelajaran');
            $table->text('kemahiran')->nullable()->after('mata_pelajaran_jawi');
            $table->text('kemahiran_jawi')->nullable()->after('kemahiran');
            $table->text('isi_pelajaran')->nullable()->after('kemahiran_jawi');
            $table->text('isi_pelajaran_jawi')->nullable()->after('isi_pelajaran');
            $table->text('aktiviti')->nullable()->after('isi_pelajaran_jawi');
            $table->text('aktiviti_jawi')->nullable()->after('aktiviti');
        });
    }

    public function down(): void
    {
        Schema::table('rph_records', function (Blueprint $table) {
            $table->dropColumn([
                'hari', 'masa',
                'mata_pelajaran', 'mata_pelajaran_jawi',
                'kemahiran', 'kemahiran_jawi',
                'isi_pelajaran', 'isi_pelajaran_jawi',
                'aktiviti', 'aktiviti_jawi',
            ]);
        });
    }
};
