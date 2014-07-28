<?php
namespace Core\Session\Handlers;

/**
* Session handler using database interface.
*/
class ArraySessionHandler implements \SessionHandlerInterface
{
	private static $session;

	/**
	* @return bool
	*/
	public function close()
	{

	}

	/**
	* @param int
	* @return bool
	*/
	public function destroy($session_id)
	{

	}

	/**
    * @param int
	* @return bool
	*/
	public function gc($maxlifetime)
	{

	}

	/**
	* @param string
	* @param string
	* @return bool
	*/
	public function open($save_path, $name)
	{

	}

	/**
    * @param string
	* @return string
	*/
	public function read($session_id)
	{
		return self::$session;
	}

	/**
	* @param string
	* @param string
	* @return bool
	*/
	public function write($session_id, $session_data)
	{

	}
}