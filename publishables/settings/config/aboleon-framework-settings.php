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
        ],
    ],
];
