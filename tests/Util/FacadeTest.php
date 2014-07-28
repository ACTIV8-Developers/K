<?php

class FacadeTest extends PHPUnit_Framework_TestCase
{
	public function testInputFacade()
	{
		$_POST['foo'] = 'bar';

		$this->assertEquals('bar', \Input::post('foo'));
	}
}