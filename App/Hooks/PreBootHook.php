<?php
namespace App\Hooks;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Core\Container\ContainerAware;

define('DEBUG', true);

class PreBootHook extends ContainerAware
{
	public function execute()
	{
        // Set error reporting.
        if (defined('DEBUG') && DEBUG === true) {
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            $this->app['whoops'] = function() {
                $whoops = new Run();
                $whoops->pushHandler(new PrettyPageHandler());
                return $whoops;
            };

            $this->app['whoops']->register();
        } else {
            ini_set('display_errors', 'Off');
            error_reporting(0);
        }

        // Set default timezone
        date_default_timezone_set('Europe/Belgrade');
	}
}