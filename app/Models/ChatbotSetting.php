<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotSetting extends Model
{
    protected $table = 'chatbot_settings';

    protected $fillable = ['data_access_enabled', 'bot_name', 'bot_avatar'];

    protected $casts = ['data_access_enabled' => 'boolean'];

    public static function current(): self
    {
        return self::firstOrCreate([], ['data_access_enabled' => false]);
    }
}
