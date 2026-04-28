<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_orders', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->foreignId('district_id')->nullable()->change();
            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('book_orders', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->foreignId('district_id')->nullable(false)->change();
            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnDelete();
        });
    }
};
