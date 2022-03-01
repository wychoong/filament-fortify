<?php

return [
    'title' => 'Register',

    'heading' => 'Register an account',

    'or' => 'Or',

    'login-link' => 'register an account',

    'buttons' => [

        'submit' => [
            'label' => 'Register',
        ],

        'login' => [
            'label' => 'Have an account?',
        ],

        'register' => [
            'label' => 'Create an account',
        ],
    ],

    'fields' => [
        'name' => [
            'label' => 'Name'
        ],

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
