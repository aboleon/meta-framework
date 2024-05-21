<?php

return [
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
    'appowner' => [
        'active' => true,
        'reg_number' => 'SIRET',
        'address_lines' => 1
    ],
];
