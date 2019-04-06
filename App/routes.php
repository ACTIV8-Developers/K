<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
| All application routes are defined here. 
| (For controllers prefix App\Controllers\ is added and isn't needed here)
*/
/** @var \Core\Routing\Router $route */
use App\Controllers\ExampleController;

$route->get('', ExampleController::class, 'indexAction');