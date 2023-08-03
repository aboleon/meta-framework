<?php
return [
    'email' => [
        'title' => 'Emails',
        'elements' => [
            [
                'name' => 'email_notification',
                'title' => 'Email d\'envoi des notifications',
                'type' => 'email',
                'class' => 'col-md-12 mb-3',
                'rules' => 'required|string|email|max:255',
                'default' => config('mail.from.address')
            ],
            [
                'name' => 'email_contact',
                'title' => 'Email recevant les demandes de contact',
                'type' => 'email',
                'class' => 'col-md-12 mb-3',
                'rules' => 'required|string|email|max:255',
                'default' => config('mail.from.address')
            ],
            [
                'name' => 'email_personal_data',
                'title' => 'Email recevant les demandes de suppressions de données personnelles',
                'type' => 'email',
                'class' => 'col-md-12',
                'rules' => 'required|string|email|max:255',
                'default' => config('mail.from.address')
            ],
        ],
    ],
];
