<?php
namespace App\Hooks;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Core\Container\ContainerAware;

class InternalErrorHook extends ContainerAware
{
	public function execute()
	{
        $this->app['whoops']->handleException($this->app['exception']);
	}
}