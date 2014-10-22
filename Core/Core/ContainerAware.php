<?php
namespace Core\Core;

/**
* Abstract class ContainerAware. Extend to gain acess to app core.
* Every called controller should be instance of ContainerAware.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
abstract class ContainerAware
{
	/**
	* @var object Core
	*/
	protected $app = null;

	/**
	* @param object Core
	*/
	public function setContainer(\Pimple\Container $app)
	{
		$this->app = $app;
	}
}