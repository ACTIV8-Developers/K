<?php

use \Core\Http\Input;

class InputTest extends PHPUnit_Framework_TestCase
{
	public function testPost()
	{
		// Create input class
		$input = new Input();

		// Simulate POST array
		$_POST['foo'] = 'bar';
		
		// Test
		$this->assertEquals($input->post('foo'),'bar');

		$_POST['bar'] = 'foo';

		$this->assertEquals($input->post(),['foo'=>'bar', 'bar'=>'foo']);

		// Simulate invalid POST array
		$_POST['foo2'] = "alert('Hacker')";

		$this->assertNotEquals($input->post('foo2', true), "alert('Hacker')");
	}
}