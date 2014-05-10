<?php 
namespace Core\Session;

/**
* Session class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Session
{
	/**
	* Class construct
	* Register handler and start session here.
	*/
	public function __construct()
	{
		$handler = new \Core\Session\Handlers\FileSession();
		session_set_save_handler($handler, true);
		session_start();
	}
}