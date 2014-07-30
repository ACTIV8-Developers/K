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

	public function testAll()
	{
		$_POST['foo'] = 'bar';

		// Test get specific input.
		$this->assertEquals($this->input->get('foo'),'bar');

		$_POST['bar'] = 'foo';

		// Test get all all.
		$this->assertEquals($this->input->post(), ['foo'=>'bar', 'bar'=>'foo']);
	}

	public function testPost()
	{
	
		// Simulate POST array
		$_POST['foo'] = 'bar';
		
		// Test
		$this->assertEquals($this->input->post('foo'), 'bar');

		$_POST['bar'] = 'foo';

		$this->assertEquals($this->input->post(), ['foo'=>'bar', 'bar'=>'foo']);

		// Simulate invalid POST array
		$_POST['foo2'] = "alert('Hacker')";

		$this->assertNotEquals($this->input->post('foo2', true), "alert('Hacker')");
	}
}