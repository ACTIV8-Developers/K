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
    'auto_start' => true,
    'sess_driver' => 'cookie',
    'sess_expiration' => 7200,
    'sess_expire_on_close' => false,
    'sess_encrypt_cookie' => false,
    'sess_use_database' => false,
    'sess_table_name' => 'sessions',
    'sess_match_ip' => false,
    'sess_match_useragent' => false,
    'sess_time_to_update' => 300
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
	],
];