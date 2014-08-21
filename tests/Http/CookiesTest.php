<?php
use \Core\Http\Cookies;

class CookiesTest extends PHPUnit_Framework_TestCase
{
	public function testGetAndSet()
	{
		$cookies = new Cookies();

		$_COOKIE['foo'] = 'bar';

		$this->assertEquals($cookies->get('foo'), 'bar');
	}
}