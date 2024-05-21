<?php

return [
    'validation' => [
        'email_contact.required' => __('validation.required', ['attribute' => config('aboleon-framework-settings.email.elements.0.title')]),
        'email_contact.email' => __('validation.email', ['attribute' => config('aboleon-framework-settings.email.elements.0.title')]),
        'email_contact.max' => __('validation.max.numeric', [
            'attribute' => config('aboleon-framework-settings.email.elements.0.title'),
            'max' => 255
        ]),
    ]
];
