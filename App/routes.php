<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
| All application routes are defined here. 
| (For controllers prefix const is CONTROLLERS_ROOT if defined otherwise App\Controllers\E is added and isn't needed here)
*/
$route->get('', 'ExampleController', 'indexAction');
$route->get('contact', 'ExampleController', 'contactAction');