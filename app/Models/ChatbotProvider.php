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
        'deepseek'  => '🧠',
        'openai'    => '✨',
        'gemini'    => '♊',
        'groq'      => '⚡',
        'anthropic' => '🔮',
    ];

    // Model suggestions per provider (for datalist)
    public const MODEL_SUGGESTIONS = [
        'deepseek'  => ['deepseek-chat', 'deepseek-reasoner'],
        'openai'    => ['gpt-4o', 'gpt-4o-mini', 'o1', 'o1-mini', 'o3-mini'],
        'gemini'    => ['gemini-2.0-flash', 'gemini-1.5-flash', 'gemini-1.5-pro'],
        'groq'      => ['llama-3.3-70b-versatile', 'llama-3.1-8b-instant', 'mixtral-8x7b-32768'],
        'anthropic' => ['claude-opus-4-5', 'claude-sonnet-4-5', 'claude-haiku-3-5', 'claude-3-5-sonnet-latest', 'claude-3-5-haiku-latest'],
    ];

    // Providers trusted with full data access (not China-based)
    public const SAFE_PROVIDERS = ['openai', 'gemini', 'groq', 'anthropic'];

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
