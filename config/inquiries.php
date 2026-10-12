<?php

return [
    'daily_limit' => (int) env('INQUIRY_DAILY_LIMIT', 50),
    'duplicate_seconds' => 600,
    'turnstile' => [
        'enabled' => env('TURNSTILE_ENABLED', true),
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
        'hostnames' => ['roxelinvest.com', 'www.roxelinvest.com'],
        'action' => 'contact',
    ],
];
