<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotProvider extends Model
{
    protected $fillable = [
        'name', 'slug', 'api_key', 'base_url', 'model',
        'is_active', 'is_free', 'is_enabled', 'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'is_free'    => 'boolean',
        'is_enabled' => 'boolean',
    ];

    // Provider icons for UI
    public const ICONS = [
        'deepseek' => '🧠',
        'openai'   => '✨',
        'gemini'   => '♊',
        'groq'     => '⚡',
    ];

    // Providers trusted with full data access (not China-based)
    public const SAFE_PROVIDERS = ['openai', 'gemini', 'groq'];

    public function getIconAttribute(): string
    {
        return self::ICONS[$this->slug] ?? '🤖';
    }

    public function getIsSafeAttribute(): bool
    {
        return in_array($this->slug, self::SAFE_PROVIDERS);
    }

    public function getDecryptedKeyAttribute(): ?string
    {
        if (!$this->api_key) return null;
        try {
            return decrypt($this->api_key);
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function active(): ?self
    {
        return self::where('is_active', true)->where('is_enabled', true)->first();
    }
}
