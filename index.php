<?php
/**
* K - Simplistic solution for full featured MVC framework
*
* The MIT License (MIT)
*
* Copyright (c) 2014 Milos Kajnaco <miloskajnaco@gmail.com>
* 
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
* @link http://kframework.info/
* @version 0.9
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
