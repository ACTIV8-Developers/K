<?php
namespace App\Hooks;

use Core\Container\ContainerAware;

/**
 * Class BeforeExecuteHook
 */
class BeforeExecuteHook extends ContainerAware
{
    /**
     * Set application mode
     */
	public function __invoke()
	{
        // Set default timezone
        date_default_timezone_set('Europe/Belgrade');
	}
}