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
    'allowedOrigins' => ['http://work.ynxpyz.cn', 'http://localhost:9528'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
