<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chatbot_settings', function (Blueprint $table) {
            $table->string('bot_name')->default('Pembantu KAFA AI')->after('data_access_enabled');
            $table->string('bot_avatar')->nullable()->after('bot_name'); // storage path
        });
    }

    public function down(): void
    {
        Schema::table('chatbot_settings', function (Blueprint $table) {
            $table->dropColumn(['bot_name', 'bot_avatar']);
        });
    }
};
