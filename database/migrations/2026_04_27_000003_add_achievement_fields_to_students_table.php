<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedTinyInteger('child_order')->nullable()->after('dependents_count');
            $table->date('prev_entry_date')->nullable()->after('entry_date');
            $table->string('home_distance')->nullable()->after('address');
            $table->string('spoken_language')->nullable()->after('home_distance');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['child_order', 'prev_entry_date', 'home_distance', 'spoken_language']);
        });
    }
};
