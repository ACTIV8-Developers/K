<?php

use \Core\Http\Input;

class InputTest extends PHPUnit_Framework_TestCase
{
	public function __construct()
	{
		$_SERVER['REQUEST_METHOD'] = 'POST';

		// Create input class
		$this->input = new Input();
	}

	public function testPost()
	{	
		// Simulate POST array
		$_POST['foo'] = 'bar';
		
		// Test
		$this->assertEquals($this->input->post('foo'), 'bar');

		$_POST['bar'] = 'foo';

		$this->assertEquals($this->input->post(), ['foo'=>'bar', 'bar'=>'foo']);

		$this->assertNull($this->input->post('none'));

		// Simulate invalid POST array
		$_POST['foo2'] = "alert('Hacker')";

		$this->assertNotEquals($this->input->post('foo2', true), "alert('Hacker')");
	}
}