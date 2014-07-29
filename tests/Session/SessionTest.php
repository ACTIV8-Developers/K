<?php

class SessionTest extends PHPUnit_Framework_TestCase
{
	public function __construct()
	{
		ob_start();

		$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 6.1; WOW64)';
		$this->session = new Core\Session\Session();
	}

	public function testGetSet()
	{
		$_SESSION['foo'] = 'bar';

		$this->assertEquals('bar', $_SESSION['foo']);

		$this->session->put('bar', 'foo');

		$this->assertEquals('foo', $this->session->get('bar'));

		$this->assertTrue($this->session->has('bar'));

		$this->assertTrue(!$this->session->has('bar2'));

		$this->session->flush();

		$this->assertTrue(!$this->session->has('bar'));

		//\Session::put('foo', 'bar');
		$_SESSION['foo'] = 'bar';
		
		$this->assertEquals('bar', \Session::get('foo'));
	}
}