<?php

use \Core\Routing\Router;

class RouterTest extends PHPUnit_Framework_TestCase
{
	/**
	* Test main run method of Router class
	*/
	public function testRun()
	{
		// Create router object
		$router = new Router();

		// Create mock route and add it to router
		Router::addRoute(new MockRoute('foo/bar', [], 'GET'));

		// Inject request and run test
		$this->assertTrue($router->run('foo/bar', 'GET'));

        // Mock route should output name of passed url.
        $this->expectOutputString('foo/bar');
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

class MockRoute extends \Core\Routing\Route
{
	public function __construct($url, $callable, $requestMethod = 'ANY')
	{
        $this->url = $url;
        $this->callable = $callable;
        $this->methods[] = $requestMethod;
	}

    public function matches($uri, $method)
    {
        return true;
    }

    public function dispatch()
    {
    	echo $this->url;
    }
}