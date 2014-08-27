<?php

use \Core\Routing\Router;
use \Core\Routing\Route;

class RouterTest extends PHPUnit_Framework_TestCase
{
	/**
	* Test main run method of Router class
	*/
	public function testRun()
	{
		// Create router object
		$router = new Router();
		$route = new Route('foo/bar', [], 'GET');
		// Create mock route and add it to router
		Router::addRoute($route);

		// Inject request and run test
		$this->assertEquals($router->run('foo/bar', 'GET'), $route);

	}

	public function testRouteAdd()
	{
		$route1 = \Route::get('foo/bar', ['', '']);

		$route2 = \Route::post('bar/foo', ['', '']);

		$route3 = \Route::put('bar/foo2', ['', '']);

		$route4 = \Route::delete('bar/foo3', ['', '']);

		$route5 = \Route::any('bar/foo4', ['', '']);

		$this->assertContains($route1, Router::getRoutes());

		$this->assertContains($route2, Router::getRoutes());

		$this->assertContains($route3, Router::getRoutes());

		$this->assertContains($route4, Router::getRoutes());

		$this->assertContains($route5, Router::getRoutes());
	}
}