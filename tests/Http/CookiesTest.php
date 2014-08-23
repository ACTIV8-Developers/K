<?php
use \Core\Http\Input;

class CookiesTest extends PHPUnit_Framework_TestCase
{
	public function testGetAndSet()
	{
		$input = new Input();

		$_COOKIE['foo'] = 'bar';

		$_COOKIE['bar'] = 'foo';

		$this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $input->cookie());

		$this->assertEquals('foo', $input->cookie('bar'));

		$this->assertEquals('bar', $input->cookie('foo'));
	}
}