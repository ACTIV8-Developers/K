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
| Currently supported redis, database, file, null (native PHP sessions).
| (Redis requires PredisClient installed, database requires active PDO)
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
| Encryption Key
|--------------------------------------------------------------------------
| Encryption key is needed for use in some classes.
*/
'encryption_key' => 'super_secret',
/*
|--------------------------------------------------------------------------
| Inject dependecies
|--------------------------------------------------------------------------
| If enabled framework will try to inject hinted classes into controllers.
*/
'injectDependecies' => true,
/*
|--------------------------------------------------------------------------
| Display benchmarking.
|--------------------------------------------------------------------------
*/
'benchmark' => true
];