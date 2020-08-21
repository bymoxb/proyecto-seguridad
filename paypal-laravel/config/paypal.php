<?php

return [
    'client_id' => env('CLIENT_ID', NULL),
    'client_secret' => env('CLIENT_SECRET', NULL),

    'settings' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path('/logs/paypal.log'),
        'log.LogLevel' => 'ERROR'
    ],
];
