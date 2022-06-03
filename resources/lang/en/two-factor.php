<?php

return [
    'title' => 'Reset password',

    'heading' => 'Reset password',

    'buttons' => [

        'enable' => [
            'label' => 'Enable two factor auth',
        ],

        'disable' => [
            'label' => 'Disable',
        ],

        'regenerate' => [
            'label' => 'Regenerate recovery code',
        ],

        'show-recovery-code' => [
            'label' => 'Show recovery code',
        ],

    ],

    'label' => [
        'setup-key' => 'Setup key',
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

        'code' => [
            'label' => 'OTP code',
        ],
    ],

    'messages' => [
        'throttled' => 'Too many register attempts. Please try again in :seconds seconds.',
        'enabled' => 'Two factor authentication has been enabled',
        'scan-qr' => 'Scan the following QR code using your phone\'s authenticator application or enter the setup key.',
        'store-recovery-code' => 'Store these recovery codes in a secure place to recover access to your account if your two factor authentication device is lost.',
        'confirm-two-factor-code' => 'Confirm the two factor code by entering the OTP code from the authenticator application',
    ],

    'login' => [
        'title' => 'Two factor login',

        'heading' => 'Two factor login',

        'buttons' => [
            'submit' => [
                'label' => 'Login',
            ],

            'cancel' => [
                'label' => 'Cancel',
            ],
        ],
        'fields' => [
            'code' => [
                'label' => 'Code',
            ],

            'recovery_code' => [
                'label' => 'Recovery code',
            ],
        ]
    ],

    'page' => [
        'title' => 'Two Factor Auth',

        'navigation-group' => 'Profile',

        'navigation-label' => 'Two Factor Auth'
    ]
];
