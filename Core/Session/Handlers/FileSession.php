<?php
namespace Core\Session\Handlers;

/**
* Session handler using file interface.
*/
class FileSession implements \SessionHandlerInterface
{

	/**
	* @return bool
	*/
	public function close()
	{

	}

	/**
	* @param string
	* @return bool
	*/
	public function destroy($session_id)
	{

	}

	/**
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
	* @return string
	*/
	public function read($session_id)
	{

	}

	/**
	* @param string
	* @param string
	* @return bool
	*/
	public function write ($session_id, $session_data )
	{

	}
}