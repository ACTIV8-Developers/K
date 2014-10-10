<?php

use \Core\Util\Util;
use \Core\Util\Date;

class UtilTest extends PHPUnit_Framework_TestCase
{
	public function testBaseUrl()
	{
		// Mock random server status.
		$_SERVER['HTTP_HOST'] = 'localhost';
    	$_SERVER['SCRIPT_NAME'] = '/www/index.php';

    	// Test assets get (remember PUBLIC folder is set to 'public')
    	$this->assertEquals(Util::base('foo'), 'http://localhost/www/foo');
    	$this->assertEquals(Util::css('foo.css'), 'http://localhost/www/public/css/foo.css');
    	$this->assertEquals(Util::js('foo.js'), 'http://localhost/www/public/js/foo.js');
    	$this->assertEquals(Util::img('foo.png'), 'http://localhost/www/public/images/foo.png');
	}

	public function testDateConvert()
	{
    	// Test conversion
    	$this->assertEquals(Date::convertDate('2014-06-08'), '08-06-2014');
    	$this->assertEquals(Date::convertSrbDate('2014-06-08'), '08.06.2014.');
        // Test with custom delimiter
        $this->assertEquals(Date::convertSrbDate('2014.06.08', '.'), '08.06.2014.');
	}
}