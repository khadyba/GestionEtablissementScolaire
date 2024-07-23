<?php

return [
    'master_key' => env('PAYDUNYA_MASTER_KEY', 'y8cMxeJI-XX5N-NROr-gXqY-HTz2zZrQDfR4'),
    'public_key' => env('PAYDUNYA_PUBLIC_KEY', 'test_public_5Fg1Dfrqisxc7NSyvZ6KuCmpmVT'),
    'private_key' => env('PAYDUNYA_PRIVATE_KEY', 'test_private_X6hPYCZRwsuT8qP2YwWMlDfMGQl'),
    'mode' => env('PAYDUNYA_MODE', 'test'), 
    'token' => env('PAYDUNYA_TOKEN', 'KOGFbt62Pei91jTfOakr'),

    // 'return_url' => env('PAYDUNYA_RETURN_URL', 'http://127.0.0.1:8000/payment/callback'),
    // 'cancel_url' => env('PAYDUNYA_CANCEL_URL', 'http://127.0.0.1:8000/payment/cancel'),
    // 'callback_url' => env('PAYDUNYA_CALLBACK_URL', 'http://127.0.0.1:8000/paydunya/notify'),
];
