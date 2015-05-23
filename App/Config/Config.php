<?php
/*
|--------------------------------------------------------------------------
| APPLICATION SETTINGS
|--------------------------------------------------------------------------
*/
return [
/*
|--------------------------------------------------------------------------
| Session handler
|--------------------------------------------------------------------------
| Currently supported redis, database, encrypted-file, file (native PHP sessions).
| (Database requires active PDO)
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
    'expiration' => 0,
    // Match user agents on session requests.
    'matchUserAgent' => true,
    // Hashing algorithm used for creating security tokens.
    'hashAlgo' => 'md5',
    // Session regeneration frequency (number between 0 and 100, 0 to turn off).
    'updateFrequency' => 10
    ],
/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
| Encryption key is needed for use in some classes.
*/
'key' => 'super_secret'
];
