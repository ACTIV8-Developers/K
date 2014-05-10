<?php
/*
|--------------------------------------------------------------------------
| APPLICATION SETTINGS
|--------------------------------------------------------------------------
*/
return [
/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
*/
'session' => [
    'start' => true,
    'handler' => 'file',
    'expiration' => 7200,
    'expire_on_close' => false,
    'table_name' => 'sessions',
    'match_ip' => false,
    'match_useragent' => false,
    'time_to_update' => 300
],
/*
|--------------------------------------------------------------------------
| Cookies
|--------------------------------------------------------------------------
| 'cookie_prefix' = Set a prefix if you need to avoid collisions
| 'cookie_domain' = Set to .your-domain.com for site-wide cookies
| 'cookie_path' = Typically will be a forward slash
| 'cookie_secure' = Cookies will only be set if a secure HTTPS connection exists.
| 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
*/
'cookies' => [
    'cookie_prefix'	=> '',
    'cookie_domain' => '',
    'cookie_path' => '/',
    'cookie_secure' => false,
    'cookie_httponly' => false
],
/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
| Encryption key is needed for use in some security classes.
*/
'encryption_key' => 'abc',
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