<?php
/*
|--------------------------------------------------------------------------
| APPLICATION SETTINGS
|--------------------------------------------------------------------------
*/
return [
/*
|--------------------------------------------------------------------------
| Start session
|--------------------------------------------------------------------------
*/
'sessionStart' => false,
/*
|--------------------------------------------------------------------------
| Session handler
|--------------------------------------------------------------------------
| Currently supported file, database and null (native PHP sessions).
*/
'sessionHandler' => null,
/*
|--------------------------------------------------------------------------
| Session specific settings
|--------------------------------------------------------------------------
| All parameters are optional and default ones 
| will be used if none is passed.
*/
'session' => [
    'name' => 'K',
    'tableName' => 'sessions', // Needed only if handler is database
    'expiration' => 7200,
    'matchUserAgent' => true,
    'hashKey' => 'super_secret',
    'updateFrequency' => 10
    ],
/*
|--------------------------------------------------------------------------
| Cookies specific settings
|--------------------------------------------------------------------------
| All parameters are optional and default ones 
| will be used if none is passed.
*/
'cookies' => [
    'domain' => '',
    'path' => '/',
    'secure' => false,
    'httponly' => true
    ],
/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
| Encryption key is needed for use in some classes.
*/
'encryption_key' => 'super_secret',
/*
|--------------------------------------------------------------------------
| Display benchmarking.
|--------------------------------------------------------------------------
*/
'benchmark' => false
];