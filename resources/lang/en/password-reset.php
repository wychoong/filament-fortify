<?php

return [
    'title' => 'Reset password',

    'heading' => 'Reset password',

    'buttons' => [

        'submit' => [
            'label' => 'Send email',
        ],

        'cancel' => [
            'label' => 'Cancel',
        ],

        'reset' => [
            'label' => 'Update password',
        ],

        'request' => [
            'label' => 'Forgot password?',
        ]
    ],

    'fields' => [
        'email' => [
            'label' => 'Email address',
        ],

        'password' => [
            'label' => 'Password',
        ],

        'password_confirm' => [
            'label' => 'Confirm password',
        ],
    ],

    'messages' => [
        'throttled' => 'Too many register attempts. Please try again in :seconds seconds.',
    ],
];
