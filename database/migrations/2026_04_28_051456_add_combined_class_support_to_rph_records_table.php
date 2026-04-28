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
        Schema::table('rph_records', function (Blueprint $table) {
            // Jenis RPH: biasa atau gabungan
            $table->enum('class_type', ['biasa', 'gabungan'])->default('biasa')->after('kafa_class_id');

            // Untuk gabungan: simpan array tahun yang terlibat [1,2,3] atau [4,5,6]
            $table->json('combined_years')->nullable()->after('class_type');

            // Content per tahun (JSON) - untuk kelas gabungan
            $table->json('objectives_by_year')->nullable()->after('objective_jawi');
            $table->json('standards_by_year')->nullable()->after('objectives_by_year');
            $table->json('activities_by_year')->nullable()->after('standards_by_year');
            $table->json('assessment_by_year')->nullable()->after('activities_by_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rph_records', function (Blueprint $table) {
            $table->dropColumn([
                'class_type',
                'combined_years',
                'objectives_by_year',
                'standards_by_year',
                'activities_by_year',
                'assessment_by_year',
            ]);
        });
    }
};
