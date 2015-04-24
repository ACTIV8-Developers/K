<?php
namespace App\Middleware;

use Core\Container\ContainerAware;

class SessionMiddleware extends ContainerAware
{
	public function execute()
	{
		$this->session->start();
	}
}