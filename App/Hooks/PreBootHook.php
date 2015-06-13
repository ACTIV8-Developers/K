<?php
namespace App\Hooks;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Core\Container\ContainerAware;

/**
 * Class PreBootHook
 */
class PreBootHook extends ContainerAware
{
    /**
     * Set application mode
     */
	public function execute()
	{
        switch (APP_MODE) {
            case 'debug':
                ini_set('display_errors', 1);
                error_reporting(E_ALL);

                $this->app['whoops'] = function() {
                    $whoops = new Run();
                    $whoops->pushHandler(new PrettyPageHandler());
                    return $whoops;
                };

                $this->app['whoops']->register();

                break;
            case 'production':
                ini_set('display_errors', 'Off');
                error_reporting(0);
                break;
        }

        // Set default timezone
        date_default_timezone_set('Europe/Belgrade');
	}
}