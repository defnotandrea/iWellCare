<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Email Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for email templates and branding.
    |
    */

    'logo_url' => env('EMAIL_LOGO_URL', 'http://127.0.0.1:8000/assets/img/iWellCare-logo.png'),

    'clinic_name' => env('CLINIC_NAME', 'iWellCare Clinic'),

    'clinic_tagline' => env('CLINIC_TAGLINE', 'Your Health, Our Priority'),

    'contact' => [
        'phone' => env('CLINIC_PHONE', '09352410173'),
        'email' => env('CLINIC_EMAIL', 'info@iwellcare.com'),
        'address' => env('CLINIC_ADDRESS', 'Capitulacio Street Zone 2, Bangued, Abra'),
    ],
];
