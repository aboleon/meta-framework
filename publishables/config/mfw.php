<?php

return [
    'google_places_api_key' => env('GOOGLE_PLACES_API_KEY'),
    'translatable' => [
        'multilang' => true,
        'locales' => ['fr', 'en'],
        'active_locales' => ['fr', 'en'],
        'fallback_locale' => 'fr',
    ],
    'urls' => [
        'backend' => 'panel'
    ],
    'tables' => [
        'user' => 'users'
    ],
    'siteowner' => [
        'active' => true,
        'address_lines' => 1
    ]
];
