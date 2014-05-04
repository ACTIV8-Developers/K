<?php
/**
* Codejam portfolio website
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
* @author Vedran Milakovic <milakovic.vedran@gmail.com>
* @link http://codejam.co/
* @version 2.0
*/
/*
|--------------------------------------------------------------------------
| Set application paths
|--------------------------------------------------------------------------
| Define application folder.
*/
define('APP', __DIR__.'/App/');
/*
|--------------------------------------------------------------------------
| Set path to directory where views are stored.
|--------------------------------------------------------------------------
*/
define('APPVIEW', APP.'Views/');
/*
|--------------------------------------------------------------------------
| Set path to file containing routes.
|--------------------------------------------------------------------------
*/
define('ROUTES', APP.'routes.php');
/*
|--------------------------------------------------------------------------
| Set path to public directory
|--------------------------------------------------------------------------
*/
define('PUBLIC_PATH', __DIR__.'/public/');
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
| Composer provides a convenient, automatically generated class loader
| for application. Require it into the script here so that the loading
| of classes is done automatically.
*/
require __DIR__.'/vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Set error reporting, if true "Whoops" package will take over 
| error reporting, if false error reporting will be off.
|--------------------------------------------------------------------------
*/
if(true) {
 	ini_set("display_errors", 1);
	error_reporting(E_ALL);
	$whoops = new Whoops\Run();
	$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
	$whoops->register();
} else {
    ini_set('display_errors', 'Off');
    error_reporting(0);
}
/*
|--------------------------------------------------------------------------
| Remember starting time for later benchmarking if needed
|--------------------------------------------------------------------------
*/
PHP_Timer::start();
/*
|--------------------------------------------------------------------------
| Register aliases auto loader
|--------------------------------------------------------------------------
| Additional auto loader for prettier class names.
*/
\Core\Util\AliasLoader::getInstance(require('App/Config/Aliases.php'))->register();
/*
|--------------------------------------------------------------------------
| Create main Core class and load configuration. 
|--------------------------------------------------------------------------
| Load core class and load all dependecies.
*/
$app = Core\Core\Core::getInstance();
/*
|--------------------------------------------------------------------------
| RUN! 
|-------------------------------------------------------------------------- 
*/
$app->run();
