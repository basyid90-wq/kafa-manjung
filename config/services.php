<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],


    'bayarcash' => [
        'sandbox'         => env('BAYARCASH_SANDBOX', true),
        'api_token'       => env('BAYARCASH_API_TOKEN'),        // Personal Access Token (PAT)
        'secret_key'      => env('BAYARCASH_API_SECRET_KEY'),   // HMAC-SHA256 checksum key
        'portal_key'      => env('BAYARCASH_PORTAL_KEY'),
        'payment_channel' => (int) env('BAYARCASH_PAYMENT_CHANNEL', 1), // 1 = FPX
        'base_url'        => env('BAYARCASH_SANDBOX', true)
            ? 'https://api.console.bayarcash-sandbox.com/v3/'
            : 'https://api.console.bayar.cash/v3/',
    ],

];
