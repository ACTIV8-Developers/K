<?php
namespace App\Middleware;

use Core\Container\ContainerProvider;

class SessionMiddleware extends ContainerProvider
{
	public function execute()
	{
		$this->session->start();
	}
}