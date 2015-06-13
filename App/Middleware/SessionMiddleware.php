<?php
namespace App\Middleware;

use Core\Container\ContainerAware;

/**
 * Class SessionMiddleware
 */
class SessionMiddleware extends ContainerAware
{
	/**
	 * Start session
	 */
	public function execute()
	{
		$this->session->start();
	}
}