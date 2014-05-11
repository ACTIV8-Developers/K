<?php
/*
|--------------------------------------------------------------------------
| APPLICATION SETTINGS
|--------------------------------------------------------------------------
*/
return [
/*
|--------------------------------------------------------------------------
| Session and cookies
|--------------------------------------------------------------------------
| All parameters are optional and default ones 
| will be used if none is passed
*/
'sessionAndCookies' => [
    'start' => true,
    'name' => 'KKK',
    'handler' => 'file',// or database
    'tableName' => 'sessions', // Needed only if handler is database
    'expiration' => 7200,
    'expireOnClose' => false,
    'matchUseragent' => true,
    'updateTime' => 300
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
| Enable or disable log writing.
|--------------------------------------------------------------------------
*/
'logWrite' => false,
/*
|--------------------------------------------------------------------------
| Enable or disable log writing.
|--------------------------------------------------------------------------
*/
'logDisplay' => false,
/*
|--------------------------------------------------------------------------
| Display benchmarking.
|--------------------------------------------------------------------------
*/
'benchmark' => true,
/*
|--------------------------------------------------------------------------
| Use modules in application.
|--------------------------------------------------------------------------
| List of modules to be activated is in App\Config\Modules.php file.
*/
'modules' => false,
/*
|--------------------------------------------------------------------------
| Language support list
|--------------------------------------------------------------------------
| Used for autodetecting language from URL.
| (can be set to false if not needed)
*/
'languages' => [
    'default'=>'latin',
    'languages'=>['en']
]
];