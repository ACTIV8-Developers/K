<?php
/*
|--------------------------------------------------------------------------
| Set application path.
|--------------------------------------------------------------------------
*/
define('APP', __DIR__.'/../App/');
/*
|--------------------------------------------------------------------------
| Set name of directory and namespace where controllers are stored.
|--------------------------------------------------------------------------
| This needs to match structure defined in composer.json file, usually
| controllers are stored in App/Controllers.
*/
define('CONTROLERS', 'Controllers');
/*
|--------------------------------------------------------------------------
| Set name of directory and namespace where models are stored.
|--------------------------------------------------------------------------
| This needs to match structure defined in composer.json file.
*/
define('MODELS', 'Models');
/*
|--------------------------------------------------------------------------
| Set path to file containing routes.
|--------------------------------------------------------------------------
*/
define('ROUTES', APP.'routes.php');
/*
|--------------------------------------------------------------------------
| Set name of the public directory.
|--------------------------------------------------------------------------
*/
define('PUBLIC_DIR', 'public');
/*
|--------------------------------------------------------------------------
| Set path to the public directory.
|--------------------------------------------------------------------------
*/
define('PUBLIC_PATH', __DIR__.'/../'.PUBLIC_DIR.'/');
/*
|--------------------------------------------------------------------------
| Set default timezone
|--------------------------------------------------------------------------
*/
date_default_timezone_set('Europe/Belgrade');
/*
|--------------------------------------------------------------------------
| Register the composer auto loader
|--------------------------------------------------------------------------
*/
require __DIR__.'/../vendor/autoload.php';