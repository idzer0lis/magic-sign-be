<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */

    'supportsCredentials' => true,
    //'allowedOrigins' => env('CORS_ALLOWED_ORIGINS') ? explode(',', env('CORS_ALLOWED_ORIGINS')) : ['*'],
    'allowedOrigins' => ['*'],
    //'allowedHeaders' => ['Content-Type', 'X-Requested-With', 'Authorization'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    'exposedHeaders' => [],
    'maxAge' => 864000,
];

