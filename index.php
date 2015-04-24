<?php
/*
| K
|--------------------------------------------------------------------------
| The MIT License (MIT)
|
| Copyright (c) 2015 Milos Kajnaco <milos@caenazzo.com>
| 
| Permission is hereby granted, free of charge, to any person obtaining a copy
| of this software and associated documentation files (the "Software"), to deal
| in the Software without restriction, including without limitation the rights
| to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
| copies of the Software, and to permit persons to whom the Software is
| furnished to do so, subject to the following conditions:
|
| The above copyright notice and this permission notice shall be included in
| all copies or substantial portions of the Software.
|
| THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
| IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
| FITNESS FOR A PARTICULAR PURPOSE AND NONINFINGEMENT. IN NO EVENT SHALL THE
| AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
| LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
| OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
| THE SOFTWARE.
|
| @author Milos Kajnaco <milos@caenazzo.com>
| @link http://kframework.co
*/
use Core\Core\Core;
use Core\Util\AliasLoader;
/*
|--------------------------------------------------------------------------
| Register the composer auto loader
|--------------------------------------------------------------------------
*/
require __DIR__ . '/vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Register aliases auto loader.
|--------------------------------------------------------------------------
| Additional auto loader for prettier class names.
*/
AliasLoader::getInstance(require(__DIR__ . '/App/Config/Aliases.php'))->register();
/*
|--------------------------------------------------------------------------
| Create core application class instance
|--------------------------------------------------------------------------
*/
$app = Core::getInstance(__DIR__ . '/App')->setNamespacePrefix('App\Controllers');
/*
|--------------------------------------------------------------------------
| Hooks
|--------------------------------------------------------------------------
*/
$app->setHook('before.boot', 'App\Hooks\PreBootHook');
/*
|--------------------------------------------------------------------------
| Middleware
|--------------------------------------------------------------------------
*/
$app->addMiddleware('App\Middleware\SessionMiddleware');
/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
*/
$app->addService('Core\Auth\AuthServiceProvider')
	->addService('Core\Session\SessionServiceProvider')
	->addService('Core\Database\DatabaseServiceProvider');
/*
|--------------------------------------------------------------------------
| Boot appplication
|--------------------------------------------------------------------------
*/
$app->boot();
/*
|--------------------------------------------------------------------------
| Execute application
|-------------------------------------------------------------------------- 
*/
$app->execute();
/*
|--------------------------------------------------------------------------
| Send application response
|-------------------------------------------------------------------------- 
*/
$app->sendResponse();