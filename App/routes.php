<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
| All application routes are defined here. 
| (For controllers prefix App\Controllers is added automaticly and it isn't needed here)
*/
$route->get('', 'ExampleController', 'indexAction');
$route->get('contact', 'ExampleController', 'contactAction');