<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'paydunya' => [
    'base_url' => env('PAYDUNYA_BASE_URL', 'https://app.paydunya.com/sandbox-api/v1'),
    'master_key' => env('PAYDUNYA_MASTER_KEY', 'y8cMxeJI-XX5N-NROr-gXqY-HTz2zZrQDfR4'),
    'public_key' => env('PAYDUNYA_PUBLIC_KEY','test_public_5Fg1Dfrqisxc7NSyvZ6KuCmpmVT'),
    'private_key' => env('PAYDUNYA_PRIVATE_KEY','test_private_X6hPYCZRwsuT8qP2YwWMlDfMGQl'),
    'token' => env('PAYDUNYA_TOKEN','KOGFbt62Pei91jTfOakr'),
],



];
