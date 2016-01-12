<?php
namespace App\Hooks;

use Core\Container\ContainerAware;

/**
 * Class InternalErrorHook
 */
class InternalErrorHook extends ContainerAware
{
	/**
	 * Set whoops to handle application errors
	 *
	 * @param \Exception $e
	 */
	public function __invoke(\Exception $e)
	{
        $this->container['whoops']->handleException($e);
	}
}