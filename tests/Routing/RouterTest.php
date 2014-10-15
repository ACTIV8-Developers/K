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
		$router->addRoute($route);

		// Inject request and run test
		$this->assertEquals($router->run('foo/bar', 'GET'), $route);

		$this->assertEquals($router->run('foo/bar', 'POST'), false);

	}

	public function testRouteAdd()
	{
		// Create router object
		$router = new Router();
		
		$route1 = $router->get('foo/bar', ['', '']);

		$route2 = $router->post('bar/foo', ['', '']);

		$route3 = $router->put('bar/foo2', ['', '']);

		$route4 = $router->delete('bar/foo3', ['', '']);

		$route5 = $router->get('bar/foo4', ['', '']);

		$this->assertContains($route1, $router->getRoutes());

		$this->assertContains($route2, $router->getRoutes());

		$this->assertContains($route3, $router->getRoutes());

		$this->assertContains($route4, $router->getRoutes());

		$this->assertContains($route5, $router->getRoutes());
	}
}