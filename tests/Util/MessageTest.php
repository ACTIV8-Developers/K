<?php

use \Core\Util\Message;

class MessageTest extends PHPUnit_Framework_TestCase
{
	public function testSetGet()
	{
		// Set message.
		Message::set('msg', 'Hello world!');

		// First read we get message.
		$this->assertEquals(Message::get('msg', true), 'Hello world!');

		// Second time is preserved since true is also sent along last call.
		$this->assertEquals(Message::get('msg'), 'Hello world!');

		// Third read message is no more.
		$this->assertEquals(Message::get('msg'), null);
	}
}