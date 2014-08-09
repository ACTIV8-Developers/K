<?php

use \Core\Routing\Route;

class RouteTest extends PHPUnit_Framework_TestCase
{
	public function testConstructAndGet()
	{
		$route = new Route('foo/bar', ['foo', 'bar'], 'PUT');

		// Did route URL set properly ?
		$this->assertEquals('foo/bar', $route->getUrl());

		// Add one more method.
		$route->viaPost();

		// Is array of methods good now ?
		$this->assertEquals(['PUT', 'POST'], $route->getHttpMethods());

		// Add one more method.
		$route->viaGet();

		// Is array of methods good now ?
		$this->assertEquals(['PUT', 'POST', 'GET'], $route->getHttpMethods());

		// Test get callable.
		$this->assertEquals(['foo', 'bar'], $route->getCallable());
	}

	public function testMatches()
	{
		/* Test random routing casses.
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

		// Case 4
		$route4 = new Route('foo/bar/:param', [], 'GET');

		$this->assertTrue($route4->matches('foo/bar/foobar','GET'));

		$this->assertFalse($route4->matches('foo/bar/foo/bar','GET'));

		// Case 5
		$route5 = new Route('foo/bar', [], 'ANY');

		$this->assertTrue($route5->matches('foo/bar','GET'));

		$this->assertTrue($route5->matches('foo/bar/','POST'));

		// Case 6
		$route6 = new Route('foo', [], 'PUT');

		$this->assertTrue($route6->matches('foo/','PUT'));

		$this->assertFalse($route6->matches('foo/bar','PUT'));

		// Case 7
		$route7 = new Route('foo/:cat/:id/:sort', [], 'DELETE');

		$this->assertTrue($route7->matches('foo/2/3/asc','DELETE'));

		$this->assertFalse($route7->matches('foo/bar/are/','DELETE'));

		// Case 8
		$route8 = new Route('foo/bar', [], 'GET');

		$this->assertTrue($route8->matches('foo/bar','GET'));

		$this->assertFalse($route8->matches('foo','GET'));

		// Case 9
		$route9 = new Route('foo/:id/bar/jar', [], 'GET');

		$this->assertTrue($route9->matches('foo/22/bar/jar/','GET'));

		$this->assertFalse($route9->matches('foo/44/bar/jara','GET'));

		// Case 10
		$route10 = new Route('foo/:id/bar/jar/bar/dar/:param', [], 'HEAD');

		$this->assertTrue($route10->matches('foo/22/bar/jar/bar/dar/somevalue','HEAD'));

		$this->assertFalse($route10->matches('foo//bar/jar/bar/dar/somevalue','HEAD'));
	}

	public function testMatchesWithCondition()
	{
		/* Test random routing regex conditions.
		* (callable parameter can be empty here since route won't be dispatched)
		******************************/

		// Case 1
		$route1 = new Route('foo/:param', [], 'GET');
		$route1->where('param', 'numeric');

		$this->assertFalse($route1->matches('foo/bar','GET'));

		$this->assertTrue($route1->matches('foo/123','GET'));

		$this->assertFalse($route1->matches('foo/a2c','GET'));

		// Case 2
		$route2 = new Route('foo/:param', [], 'GET');
		$route2->where('param', 'alpha-lowercase');

		$this->assertFalse($route2->matches('foo/BAR','GET'));

		$this->assertTrue($route2->matches('foo/bar','GET'));

		// Case 3
		$route3 = new Route('foo/:param', [], 'GET');
		$route3->where('param', 'alpha-numeric');

		$this->assertFalse($route3->matches('foo/Ba#R$','GET'));

		$this->assertTrue($route3->matches('foo/baR34','GET'));

		// Case 4
		$route4 = new Route('foo/:param', [], 'GET');
		$route4->where('param', 'alpha');

		$this->assertFalse($route4->matches('foo/bar2','GET'));

		$this->assertTrue($route4->matches('foo/bar','GET'));

		// Case 5
		$route5 = new Route('foo/:param', [], 'GET');
		$route5->where('param', 'real-numeric');

		$this->assertFalse($route5->matches('foo/bar2.6','GET'));

		$this->assertTrue($route5->matches('foo/3.5','GET'));

		// Case 6 custom filter
		$route6 = new Route('foo/:param', [], 'GET');
		$route6->filter('param', 'a{3}');

		$this->assertFalse($route6->matches('foo/aaab','GET'));

		$this->assertTrue($route6->matches('foo/aaa','GET'));
	}

	public function testGetParams()
	{
		$route = new Route('foo/:param', [], 'GET');

		$this->assertEmpty($route->getParams());

		// Route must match in order to get params, before that it will be empty.
		$this->assertTrue($route->matches('foo/bar','GET'));

		$this->assertEquals(['param' => 'bar'], $route->getParams());
	}
}