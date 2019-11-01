<?php
/*
|--------------------------------------------------------------------------
| APPLICATION SETTINGS
|--------------------------------------------------------------------------
*/
return [
/*
|--------------------------------------------------------------------------
| Routes file path
|--------------------------------------------------------------------------
*/
'routesPath' => __DIR__ . '/../routes.php',
/*
|--------------------------------------------------------------------------
| Views folder path
|--------------------------------------------------------------------------
*/
'viewsPath' => __DIR__ . '/../Views',
/*
|--------------------------------------------------------------------------
| Database config file path
|--------------------------------------------------------------------------
*/
'dbConfigPath' => __DIR__ . '/Database.php',
/*
|--------------------------------------------------------------------------
| Session handler
|--------------------------------------------------------------------------
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
*/
'key' => 'super_secret',
    /*
|--------------------------------------------------------------------------
| Mailer
|--------------------------------------------------------------------------
*/
'mailer' => [
    'email' => getenv("MAIL_EMAIL"),
    'password' => getenv("MAIL_PASSWORD"),
    'host' => getenv("MAIL_HOST"),
    'port' => getenv("MAIL_PORT"),
    'security' => getenv("MAIL_SECURITY")
],
/*
|--------------------------------------------------------------------------
| Redis
|--------------------------------------------------------------------------
*/
'redis' => [
    'host' => getenv("REDIS_HOST"),
    'port' => getenv("REDIS_PORT")
]
];
