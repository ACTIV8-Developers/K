<?php

use \Core\Util\Message;

class MessageTest extends PHPUnit_Framework_TestCase
{
	public function testSetGet()
	{
		// Set message
		Message::set('msg', 'Hello world!');

		// First read we get message
		$this->assertEquals(Message::get('msg'), 'Hello world!');

		// Second read message is no more
		$this->assertEquals(Message::get('msg'), null);
	}
}