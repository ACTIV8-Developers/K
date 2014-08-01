<?php
use \Core\Http\Cookies;

class CookiesTest extends PHPUnit_Framework_TestCase
{
	public function testGetSet()
	{
		$cookies = new Cookies();

		$_COOKIE['foo'] = 'bar';

		$this->assertEquals($cookies->get('foo'), 'bar');
	}
}