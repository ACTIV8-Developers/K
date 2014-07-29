<?php

use \Core\Http\Response;

// Define location of mock views to this dir
define('APPVIEW', __DIR__.'/MockViews/');

class ResponseTest extends PHPUnit_Framework_TestCase
{
	public function testRenderStaticPage()
	{
		// Create instance of response class
		$response = new Response();

		// Try rendering view with no passed data
		$view = 'MockView';
		$response->render($view, []);

		// Output string should be same as content of MockView.php file
		$this->assertEquals($response->getBody(), file_get_contents(APPVIEW.$view.'.php'));
	}

	public function testRenderDynamicPage()
	{
		// Create instance of response class
		$response = new Response();

		// Used view files
		$view = 'MockDynamicView';
		$compareView = 'MockDynamicViewCompare';

		// Buffer view to nest in main MockView
		$data['content'] = '<div>Test</div>';

		// Output main and nested view
		$response->render($view, $data);

		// Output string shoudl be same as content of MockNestedViewTest.php file
		$this->assertEquals($response->getBody(), file_get_contents(APPVIEW.$compareView.'.php'));
	}

	public function testDisplay()
	{
		// Create instance of response class
		$response = new Response();

		// Test HTML
		$test = '<h1>Test</h2>';
		$append = '<div>Message</div>';

		// Set body
		$response->setBody($test);

		// Append body
		$response->appendBody($append);

		// Display and send headers
		$response->send();

		$this->expectOutputString($test.$append);
	}

	public function testSetHeader()
	{
		// Create instance of response class
		$response = new Response();

		// Set header
		$response->setHeader('Cache-Control', 'no-cache, must-revalidate');

		$this->assertEquals($response->getHeaders(), [["Cache-Control: no-cache, must-revalidate", true]]);
	}

	public function testSendJSON()
	{
		// Create instance of response class
		$response = new Response();

		// Dummy array
		$a = ['for'=>'bar', 'bar'=>'foo'];

		// Send JSON test
		$response->sendJSON($a);

		// Test result
		$this->assertEquals(json_decode($response->getBody(), true), $a);
	}
}