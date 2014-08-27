<?php
use \Core\Http\Response;

// Define location of mock views to this dir
define('APPVIEW', __DIR__.'/MockViews/');

class BaseControllerTest extends PHPUnit_Framework_TestCase
{
	public function testGet()
	{
		// Minimal request needed information.
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$_SERVER['REQUEST_URI'] = '';

		$con = new MockController();

		$this->assertSame(\Core\Core\Core::getInstance()['request'], $con->getRequest());
		$this->assertSame(\Core\Core\Core::getInstance()['response'], $con->getResponse());
		$this->assertSame(\Core\Core\Core::getInstance()['session'], $con->getSession());
	}

	public function testRender()
	{
		/*
		$response = new Response();
		$con = new MockController();

		// Try rendering view with no passed data
		$view = 'MockView';
		$con->render($view);

		// Output string should be same as content of MockView.php file
		$this->expectOutputString(file_get_contents(APPVIEW.$view.'.php'));
		*/
	}

}

class MockController extends \Controller
{
	public function getSession()
	{
		return $this->session();
	}

	public function getRequest()
	{
		return $this->request();
	}

	public function getResponse()
	{
		return $this->response();
	}

    public function render($view)
    {
    	$this->render($view);
    }
}