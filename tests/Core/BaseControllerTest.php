<?php
use \Core\Http\Response;

// Define location of mock views to this dir
define('APPVIEW', __DIR__.'/MockViews/');

class BaseControllerTest extends PHPUnit_Framework_TestCase
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
		$this->assertInstanceOf('Core\Http\Request', $con->getRequest());

		$lib = $con->getLibrary('Library');
		$this->assertInstanceOf('Core\Libraries\Library\Library', $lib);

		$this->assertSame(\Core\Core\Core::getInstance()['request'], $con->getRequest());
		$this->assertSame(\Core\Core\Core::getInstance()['response'], $con->getResponse());
		$this->assertSame(\Core\Core\Core::getInstance()['session'], $con->getSession());
	}

	public function testRenderStaticPage()
	{
		$response = new Response();
		$con = new MockController();

		// Try rendering view with no passed data
		$view = 'MockView';
		$con->render($view, []);

		// Output string should be same as content of MockView.php file
		$this->assertEquals($response->getBody(), file_get_contents(APPVIEW.$view.'.php'));
	}

	public function testRenderDynamicPage()
	{
		$response = new Response();
		$con = new MockController();

		// Used view files
		$view = 'MockDynamicView';
		$compareView = 'MockDynamicViewCompare';

		// Buffer view to nest in main MockView
		$data['content'] = '<div>Test</div>';

		// Output main and nested view
		$res = $con->render($view, $data);

		$response->setBody($res);

		// Output string shoudl be same as content of MockNestedViewTest.php file
		$this->assertEquals($response->getBody(), file_get_contents(APPVIEW.$compareView.'.php'));
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

    public function getLibrary($name)
    {
        return $this->library($name);
    }

    public function render($view, $data = [], $display = false)
    {
    	$this->render($view, $data, $display);
    }
}