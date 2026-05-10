<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chatbot_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // "DeepSeek V4 Pro"
            $table->string('slug')->unique();              // "deepseek"
            $table->text('api_key')->nullable();           // encrypted
            $table->string('base_url');
            $table->string('model');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_free')->default(false);
            $table->boolean('is_enabled')->default(true);  // boleh disable sesebuah provider
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('chatbot_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('data_access_enabled')->default(false);
            $table->timestamps();
        });

        // Seed default providers
        DB::table('chatbot_providers')->insert([
            [
                'name'       => 'DeepSeek V4 Pro',
                'slug'       => 'deepseek',
                'api_key'    => null,
                'base_url'   => 'https://api.deepseek.com/v1',
                'model'      => 'deepseek-chat',
                'is_active'  => true,
                'is_free'    => false,
                'is_enabled' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'OpenAI (ChatGPT)',
                'slug'       => 'openai',
                'api_key'    => null,
                'base_url'   => 'https://api.openai.com/v1',
                'model'      => 'gpt-4o',
                'is_active'  => false,
                'is_free'    => false,
                'is_enabled' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Google Gemini Flash',
                'slug'       => 'gemini',
                'api_key'    => null,
                'base_url'   => 'https://generativelanguage.googleapis.com/v1beta/openai',
                'model'      => 'gemini-2.0-flash',
                'is_active'  => false,
                'is_free'    => true,
                'is_enabled' => false,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Groq (Llama — Percuma)',
                'slug'       => 'groq',
                'api_key'    => null,
                'base_url'   => 'https://api.groq.com/openai/v1',
                'model'      => 'llama-3.3-70b-versatile',
                'is_active'  => false,
                'is_free'    => true,
                'is_enabled' => false,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed default global settings (single row)
        DB::table('chatbot_settings')->insert([
            'data_access_enabled' => false,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_providers');
        Schema::dropIfExists('chatbot_settings');
    }
};
