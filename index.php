<?php
/*
| K
|--------------------------------------------------------------------------
| The MIT License (MIT)
|
| Copyright (c) 2014 Milos Kajnaco <miloskajnaco@gmail.com>
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
| @author Milos Kajnaco <miloskajnaco@gmail.com>
| @link http://kframework.co/
| @version 1.3
*/
/*
|--------------------------------------------------------------------------
| Set application path.
|--------------------------------------------------------------------------
*/
define('APP', __DIR__.'/App/');
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
| Set name of the public/web directory.
|--------------------------------------------------------------------------
*/
define('PUBLIC_DIR', 'public');
/*
|--------------------------------------------------------------------------
| Set path to the public/web directory.
|--------------------------------------------------------------------------
*/
define('PUBLIC_PATH', __DIR__.'/'.PUBLIC_DIR.'/');
/*
|--------------------------------------------------------------------------
| Register the composer auto loader.
|--------------------------------------------------------------------------
| Composer provides a convenient, automatically generated class loader
| for application. Require it into the script here so that the loading
| of classes is done automatically.
*/
require __DIR__.'/vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Register aliases auto loader.
|--------------------------------------------------------------------------
| Additional auto loader for prettier class names.
*/
\Core\Util\AliasLoader::getInstance(require(APP.'Config/Aliases.php'))->register();
/*
|--------------------------------------------------------------------------
| Create main Core class.
|--------------------------------------------------------------------------
| Load core class and load all dependencies.
*/
$app = Core\Core\Core::getInstance();
/*
|--------------------------------------------------------------------------
| Include hooks.
|--------------------------------------------------------------------------
*/
include APP.'Hooks/Hooks.php';
/*
|--------------------------------------------------------------------------
| Start request process lifecycle.
|-------------------------------------------------------------------------- 
*/
$app->run();