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
'sessionStart' => true,
/*
|--------------------------------------------------------------------------
| Session handler
|--------------------------------------------------------------------------
| Currently supported file, database and null (native PHP sessions)
*/
'sessionHandler' => null,
/*
|--------------------------------------------------------------------------
| Session and cookies specific settings
|--------------------------------------------------------------------------
| All parameters are optional and default ones 
| will be used if none is passed.
*/
'sessionAndCookies' => [
    'name' => 'K',
    'tableName' => 'sessions', // Needed only if handler is database
    'expiration' => 7200,
    'updateChance' => 30,
    'matchUserAgent' => true
    ],
/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
| Encryption key is needed for use in some security classes.
*/
'encryption_key' => 'abc123',
/*
|--------------------------------------------------------------------------
| Display benchmarking.
|--------------------------------------------------------------------------
*/
'benchmark' => true,
/*
|--------------------------------------------------------------------------
| Language support list
|--------------------------------------------------------------------------
| Used for auto detecting language from URL.
| (can be set to false if not needed)
*/
'languages' => [
    'default'=>'latin',
    'languages'=>['en']
    ]
];