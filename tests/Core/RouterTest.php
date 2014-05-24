<?php

use \Core\Core\Router;

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

		// Create mock request
		$request = new MockRequest('foo/bar', 'GET');

		// Inject request and run test
		$this->assertTrue($router->run($request));

        // Mock route should output name of passed url.
        $this->expectOutputString('foo/bar');
	}
}

class MockRoute
{
  	/**
    * The route pattern (The URL pattern (e.g. "/article/:id")).
	* @var string 
	*/
	private $url;

  	/**
    * List of supported HTTP methods for route.
	* @var array
	*/
	private $methods = [];

    /**
    * The route callable (name of controller and function to execute).
	* @var array
	*/
    private $callable;

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

class MockRequest
{
	/**
	* Request URI.
	* @var string 
	*/
	private $uri;
	
	/**
	* Request method
	* @var string
	*/
	private $requestMethod;

	public function __construct($uri, $method)
	{
		$this->uri = $uri;
		$this->requestMethod = $method;
	}

    public function getUri()
    {
        return $this->uri;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }
}