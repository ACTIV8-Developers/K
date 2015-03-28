<?php
/*
|--------------------------------------------------------------------------
| APPLICATION SETTINGS
|--------------------------------------------------------------------------
*/
return [
/*
|--------------------------------------------------------------------------
| Debug mode (will display errors and exceptions)
|--------------------------------------------------------------------------
*/
'debug' => true,
/*
|--------------------------------------------------------------------------
| Use whoops for error and exception handling
|--------------------------------------------------------------------------
*/
'whoops' => true,
/*
|--------------------------------------------------------------------------
| Default timezone (delete if already set in PHP configuration)
|--------------------------------------------------------------------------
*/
'timezone' => 'Europe/Belgrade',
/*
|--------------------------------------------------------------------------
| Start session
|--------------------------------------------------------------------------
| Automatic session start on every request.
*/
'sessionStart' => false,
/*
|--------------------------------------------------------------------------
| Session handler
|--------------------------------------------------------------------------
| Currently supported redis, database, encrypted-file, file (native PHP sessions).
| (Redis requires PredisClient installed, database requires active PDO)
*/
'sessionHandler' => 'file',
/*
|--------------------------------------------------------------------------
| Session specific settings
|--------------------------------------------------------------------------
| All parameters are optional and default ones will be used if none is passed.
*/
'session' => [
	// Session Cookie Name
    'name' => 'K',
    // Connection name (needed only if handler is database).
    'connName' => 'default',
    // Session table name (needed only if handler is database).
    'tableName' => 'sessions',
    // Session Lifetime.
    'expiration' => 7200,
    // Match user agents on session requests.
    'matchUserAgent' => true,
    // Hashing algorithm used for creating security tokens.
    'hashAlgo' => 'md5',
    // Session regeneration frequency (number between 0 and 100, 0 to turn off).
    'updateFrequency' => 10
    ],
/*
|--------------------------------------------------------------------------
| Redis configuration.
|--------------------------------------------------------------------------
*/
'redis' => [
    'scheme' => 'tcp',
    'host' => '127.0.0.1',
    'port' => 6379
    ],
/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
| Encryption key is needed for use in some classes.
*/
'key' => 'super_secret',
/*
|--------------------------------------------------------------------------
| Append benchmark results at end as HTML comment
|--------------------------------------------------------------------------
*/
'benchmark' => true,
/*
|--------------------------------------------------------------------------
| Service providers.
|--------------------------------------------------------------------------
*/
'services' => [
    '\Core\Auth\AuthServiceProvider'
    ]
];
