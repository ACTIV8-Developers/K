<?php

use \Core\Core\Route;

class RouteTest extends PHPUnit_Framework_TestCase
{
	
	public function testConstruct()
	{
		$route = new Route('foo/bar', ['foo', 'bar'], 'GET');

		// Did route URL set properly ?
		$this->assertEquals('foo/bar', $route->getUrl());

		// Add one more method.
		$route->viaPost();

		// Is array of methods good now ?
		$this->assertEquals(['GET', 'POST'], $route->getHttpMethods());

	}

	public function testMatches()
	{
		/* Test common routing casses.
		* (callable parameter can be empty here since route wont be dispatched)
		******************************/

		// Case 1
		$route1 = new Route('foo/bar', [], 'GET');

		$this->assertTrue($route1->matches('foo/bar','GET'));

		$this->assertFalse($route1->matches('foo','GET'));

		// Case 2
		$route2 = new Route(':f/:o/foo/bar/:i', [], 'GET');

		$this->assertTrue($route2->matches('en/2014/foo/bar/2','GET'));

		$this->assertFalse($route2->matches('en/2014/wrong/delete/2','GET'));


		// Case 3
		$route3 = new Route('foo/bar', [], 'POST');

		$this->assertTrue($route3->matches('foo/bar','POST'));

		$this->assertFalse($route3->matches('foo/bar','GET'));
	}
}