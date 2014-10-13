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
'sessionHandler' => null,
/*
|--------------------------------------------------------------------------
| Session specific settings
|--------------------------------------------------------------------------
| All parameters are optional and default ones will be used if none is passed.
*/
'session' => [
	// Session Cookie Name
    'name' => 'K',
    // Session table name (Needed only if handler is database)
    'tableName' => 'sessions',
    // Session Lifetime
    'expiration' => 7200,
    // Match user agents on session requests
    'matchUserAgent' => true,
    // Session regeneration frequency (0 to turn off)
    'updateFrequency' => 10
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