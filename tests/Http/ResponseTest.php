<?php

use \Core\Http\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
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
		$response->writeBody($append);

		$this->assertEquals($response->getBody(), $test.$append);
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
		$response->json($a);

		// Test result
		$this->assertEquals(json_decode($response->getBody(), true), $a);
	}
}