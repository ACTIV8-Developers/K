<?php
namespace App\Middleware;

use Core\Container\ContainerAware;
use Interop\Container\ContainerInterface;

/**
 * Class SessionMiddleware
 */
class SessionMiddleware extends ContainerAware
{
	/**
	 * Registry constructor.
	 *
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * Start session
	 * @param callable $next
	 */
	public function __invoke($next)
	{
		$this->container->get('session')->start();

		// Call next middleware
		return $next();
	}
}