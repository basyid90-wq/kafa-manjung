<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rph_periods', function (Blueprint $table) {
            // Per-year content for cantum class (JSON keyed by tahun e.g. {1:"...", 2:"..."})
            $table->json('tajuk_by_year')->nullable()->after('topic_jawi');
            $table->json('isi_pelajaran_by_year')->nullable()->after('tajuk_by_year');
            $table->json('objective_by_year')->nullable()->after('isi_pelajaran_by_year');
            $table->json('aktiviti_by_year')->nullable()->after('objective_by_year');

            // Shared per session (checkboxes)
            $table->json('kemahiran_selected')->nullable()->after('aktiviti_by_year');
            $table->json('strategi_pdc')->nullable()->after('kemahiran_selected');

            // Impak pembelajaran per session
            $table->json('impak')->nullable()->after('strategi_pdc');
        });
    }

    public function down(): void
    {
        Schema::table('rph_periods', function (Blueprint $table) {
            $table->dropColumn([
                'tajuk_by_year',
                'isi_pelajaran_by_year',
                'objective_by_year',
                'aktiviti_by_year',
                'kemahiran_selected',
                'strategi_pdc',
                'impak',
            ]);
        });
    }
};
