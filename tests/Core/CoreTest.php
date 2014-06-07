<?php

class CoreTest extends PHPUnit_Framework_TestCase
{
	public function __construct()
	{
		// Mock random request
		$_SERVER['REQUEST_URI'] = '/public/foo/bar/2';
		$_SERVER['SCRIPT_NAME'] = '/public/index.php';
		$_SERVER['QUERY_STRING'] = '';
		$_SERVER['REQUEST_METHOD'] = 'GET';
	}

	public function testGet()
	{
		// Make instance of app
		$app = Core\Core\Core::getInstance();

		// Check if construct made all required things.
		$this->assertInstanceOf('Core\Core\Core', $app);
		$this->assertInstanceOf('Core\Http\Response', $app['response']);
		$this->assertInstanceOf('Core\Http\Input', $app['input']);
		$this->assertInstanceOf('Core\Http\Request', $app['request']);	
	}

	public function testHooks()
	{
		// Make instance of app
		$app = Core\Core\Core::getInstance();

		// Make some functions.
		$function1 = function($app) {
			$app['foo'] = 'bar';
		};

		$function2 = function($app) {
			$app['bar'] = 'foo';
		};

		// Make hooks
		$app->hook('before.routing', $function1);
		$app->hook('after.routing', $function2);

		// Test hooks
		$this->assertEquals($app->getHook('before.routing'), $function1);
		$this->assertEquals($app->getHook('after.routing'), $function2);
	}
}