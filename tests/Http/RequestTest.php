<?php
use \Core\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
	public function testConstruct()
	{
		// Mock random request
		$_SERVER['REQUEST_URI'] = '/public/foo/bar/2';
		$_SERVER['SCRIPT_NAME'] = '/public/index.php';
		$_SERVER['QUERY_STRING'] = '';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$request1 = new Request();

		// Test URI
		$this->assertEquals($request1->getUri(), 'foo/bar/2');

		// Test method
		$this->assertEquals($request1->getRequestMethod(), 'GET');

		// Mock random request
		$_SERVER['REQUEST_URI'] = '/public/foo/bar/';
		$_SERVER['SCRIPT_NAME'] = '/public/index.php';
		$_SERVER['QUERY_STRING'] = '?foo=2&bar=3';
		$_SERVER['REQUEST_METHOD'] = 'POST';

		$request2 = new Request();

		// Test URI
		$this->assertEquals($request2->getUri(), 'foo/bar');

		// Test method
		$this->assertEquals($request2->getRequestMethod(), 'POST');
	}

	public function testSegment()
	{
		// Mock random request
		$_SERVER['REQUEST_URI'] = '/public/foo/bar/2';
		$_SERVER['SCRIPT_NAME'] = '/public/index.php';
		$_SERVER['QUERY_STRING'] = '';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$request1 = new Request();

		$this->assertEquals($request1->segment(0), 'foo');

		$this->assertEquals($request1->segment(2), '2');


	}
}