<?php

class ControllerTest extends PHPUnit_Framework_TestCase
{
	public function __construct()
	{
		// Mock random request.
		$_SERVER['REQUEST_URI'] = '/public/foo/bar/2';
		$_SERVER['SCRIPT_NAME'] = '/public/index.php';
		$_SERVER['QUERY_STRING'] = '';
		$_SERVER['REQUEST_METHOD'] = 'GET';
	}

	public function testGet()
	{
		$con = new MockController();

		$this->assertInstanceOf('Core\Session\Session', $con->getSession());
		$this->assertInstanceOf('Core\Http\Response', $con->getResponse());
		$this->assertInstanceOf('Core\Http\Input', $con->getInput());
		$this->assertInstanceOf('Core\Http\Request', $con->getRequest());
		$this->assertInstanceOf('Core\Http\Cookies', $con->getCookies());


		$this->assertSame(\Core\Core\Core::getInstance()['request'], $con->getRequest());
		$this->assertSame(\Core\Core\Core::getInstance()['input'], $con->getInput());
		$this->assertSame(\Core\Core\Core::getInstance()['response'], $con->getResponse());
		$this->assertSame(\Core\Core\Core::getInstance()['session'], $con->getSession());
		$this->assertSame(\Core\Core\Core::getInstance()['cookies'], $con->getCookies());
	}
}

class MockController extends \Controller
{
	public function getInput()
	{
		return $this->input();
	}

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

	public function getCookies()
	{
		return $this->cookies();
	}
}