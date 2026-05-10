<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('chatbot_providers')->insert([
            'name'       => 'Anthropic (Claude)',
            'slug'       => 'anthropic',
            'api_key'    => null,
            'base_url'   => 'https://api.anthropic.com/v1',
            'model'      => 'claude-3-5-sonnet-latest',
            'is_active'  => false,
            'is_free'    => false,
            'is_enabled' => false,
            'sort_order' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('chatbot_providers')->where('slug', 'anthropic')->delete();
    }
};
