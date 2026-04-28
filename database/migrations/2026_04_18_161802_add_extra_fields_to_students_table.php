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
        Schema::table('students', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('gender');
            $table->date('dob')->nullable()->after('profile_picture');
            $table->integer('age')->nullable()->after('dob');
            $table->string('birth_place')->nullable()->after('age');
            $table->string('race')->nullable()->after('birth_place');
            $table->string('citizenship')->nullable()->after('race');
            $table->text('address')->nullable()->after('citizenship');
            $table->string('oku_status')->nullable()->after('address');
            
            // Akademik
            $table->string('registration_no')->nullable()->after('oku_status');
            $table->string('session_year')->nullable()->after('registration_no');
            $table->date('entry_date')->nullable()->after('session_year');
            $table->string('origin_school')->nullable()->after('entry_date');
            $table->string('upkk_number')->nullable()->after('origin_school');
            $table->string('status')->nullable()->after('upkk_number');

            // Ibu Bapa / Waris
            $table->string('father_name')->nullable()->after('status');
            $table->string('father_ic')->nullable()->after('father_name');
            $table->string('father_phone')->nullable()->after('father_ic');
            $table->string('father_job')->nullable()->after('father_phone');
            $table->decimal('father_income', 10, 2)->nullable()->after('father_job');
            
            $table->string('mother_name')->nullable()->after('father_income');
            $table->string('mother_ic')->nullable()->after('mother_name');
            $table->string('mother_phone')->nullable()->after('mother_ic');
            $table->string('mother_job')->nullable()->after('mother_phone');
            $table->decimal('mother_income', 10, 2)->nullable()->after('mother_job');
            
            $table->integer('dependents_count')->nullable()->after('mother_income');
            $table->string('parents_relationship_status')->nullable()->after('dependents_count');

            // Kesihatan
            $table->text('chronic_disease')->nullable()->after('parents_relationship_status');
            $table->text('allergies')->nullable()->after('chronic_disease');
            $table->text('emergency_contact')->nullable()->after('allergies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'profile_picture', 'dob', 'age', 'birth_place', 'race', 'citizenship', 'address', 'oku_status',
                'registration_no', 'session_year', 'entry_date', 'origin_school', 'upkk_number', 'status',
                'father_name', 'father_ic', 'father_phone', 'father_job', 'father_income',
                'mother_name', 'mother_ic', 'mother_phone', 'mother_job', 'mother_income',
                'dependents_count', 'parents_relationship_status',
                'chronic_disease', 'allergies', 'emergency_contact'
            ]);
        });
    }
};
