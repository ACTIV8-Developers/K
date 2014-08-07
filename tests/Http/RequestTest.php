<?php
use \Core\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
	public function testConstruct()
	{
		// Mock random request
		$server = [
			'SERVER_NAME' => 'localhost',
			'SERVER_PORT' => 80,
			'HTTP_HOST' => 'localhost',
			'HTTP_USER_AGENT' => 'RandomAgent',
			'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'HTTP_ACCEPT_LANGUAGE' => 'en-us,en;q=0.5',
			'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
			'REMOTE_ADDR' => '127.0.0.1',
			'SCRIPT_NAME' => 'index.php',
			'SCRIPT_FILENAME' => '',
			'SERVER_PROTOCOL' => 'HTTP/1.1',
			'REQUEST_TIME' => time(),
			'REQUEST_URI' => 'foo/bar/2',
			'QUERY_STRING' => '',
			'REQUEST_METHOD' => 'PUT'
		];

		$request1 = new Request($server);

		// Test URI
		$this->assertEquals($request1->getUri(), 'foo/bar/2');

		// Test method
		$this->assertEquals($request1->getRequestMethod(), 'PUT');

		// Test get protocol
		$this->assertEquals($request1->getProtocolVersion(), 'HTTP/1.1');

		// Test get user agent
		$this->assertEquals($request1->getUserAgent(), 'RandomAgent');

		// Test get random variables
		$this->assertEquals($request1->getHeader('HTTP_HOST'), 'localhost');
		$this->assertEquals($request1->getEnv('SERVER_NAME'), 'localhost');
		$this->assertEquals($request1->getEnv('SERVER_PORT'), 80);

	}

	public function testGetAndIs()
	{
		// Mock random request
		$_SERVER['REQUEST_URI'] = '/public/foo/bar/';
		$_SERVER['SCRIPT_NAME'] = '/public/index.php';
		$_SERVER['QUERY_STRING'] = '?foo=2&bar=3';
		$_SERVER['REQUEST_METHOD'] = 'POST';

		$request2 = new Request($_SERVER);

		// Test URI
		$this->assertEquals($request2->getUri(), 'foo/bar');

		// Test method
		$this->assertEquals($request2->getRequestMethod(), 'POST');

		// Test isPost ?
		$this->assertTrue($request2->isPost());

		// Mock random request
		$server['REQUEST_URI'] = '/public/foo/bar/';
		$server['SCRIPT_NAME'] = '/public/index.php';
		$server['QUERY_STRING'] = '?foo=2&bar=3';
		$server['REQUEST_METHOD'] = 'GET';
		$server['SERVER_PROTOCOL'] = 'HTTP/1.1';

		$request3 = new Request($server);

		// Test URI
		$this->assertEquals($request3->getUri(), 'foo/bar');

		// Test get protocol
		$this->assertEquals($request3->getProtocolVersion(), 'HTTP/1.1');

		// Test is methods
		$this->assertTrue($request3->isGet());

		$this->assertFalse($request3->isPut());

		$this->assertFalse($request3->isPatch());

		$this->assertFalse($request3->isOptions());

				// Mock random request
		$server['REQUEST_URI'] = '/public/foo/bar/';
		$server['SCRIPT_NAME'] = '/public/index.php';
		$server['QUERY_STRING'] = '?foo=2&bar=3';
		$server['REQUEST_METHOD'] = 'DELETE';
		$server['SERVER_PROTOCOL'] = 'HTTP/1.1';

		$request3 = new Request($server);

		$this->assertTrue($request3->isDelete());
	}

	public function testSegment()
	{
		// Mock random request
		$_SERVER['REQUEST_URI'] = '/public/foo/bar/2';
		$_SERVER['SCRIPT_NAME'] = '/public/index.php';
		$_SERVER['QUERY_STRING'] = '';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$request1 = new Request($_SERVER);

		$this->assertEquals($request1->getUriSegment(0), 'foo');

		$this->assertEquals($request1->getUriSegment(2), '2');
	}

	public function testGetHeaders()
	{
		$_SERVER['REQUEST_URI'] = '/public/foo/bar/2';
		$_SERVER['SCRIPT_NAME'] = '/public/index.php';
		$_SERVER['QUERY_STRING'] = '';
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$_SERVER['HTTP_ACCEPT_ENCODING'] = 'gzip';
		$_SERVER['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';
		$_SERVER['CONTENT_LENGTH'] = 100;

        $req = new Request($_SERVER);
        $this->assertEquals('gzip', $req->getHeader('HTTP_ACCEPT_ENCODING'));

        $this->assertEquals(100, $req->getContentLength());
        $this->assertEquals('application/x-www-form-urlencoded', $req->getContentType());
        $this->assertNull($req->getHeader('foo'));
	}
}