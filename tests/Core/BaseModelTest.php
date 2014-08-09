<?php

class BaseModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
	public function testGetDb() // Will throw exception since it cant connect to db at this momment.
	{
		$mod = new MockModel();

		$this->assertInstanceOf('Core\Session\Session', $mod->getDatabase());

		$this->assertSame(\Core\Core\Core::getInstance()['dbdefault'], $mod->getDatabase());
	}

	public function testGetLibrary()
	{
		$mod = new MockModel();

		$lib = $mod->getLibrary('Library');

		$this->assertInstanceOf('Core\Libraries\Library\Library', $lib);

		$lib2 = $mod->getLibrary('nonexistant');

		$this->assertNull($lib2);
	}
}


class MockModel extends \Model
{
    public function getDatabase()
    {
        return $this->db();
    }

    public function getLibrary($name)
    {
        return $this->library($name);
    }
}