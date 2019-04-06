<?php
namespace App\Middleware;

use App\Models\ExampleModel;
use App\Controllers\ExampleController;
use Core\Container\ContainerAware;
use Core\Database\DatabaseServiceProvider;
use Core\Session\SessionServiceProvider;
use Psr\Container\ContainerInterface;

/**
 * Class RegistryMiddleware
 */
class RegistryMiddleware extends ContainerAware
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
     * @param callable $next
     */
    public function __invoke($next)
    {
        // Register session service
        /** @var SessionServiceProvider $sessionServiceProvider */
        $sessionServiceProvider = (new SessionServiceProvider())->setContainer($this->container);
        $sessionServiceProvider();

        // Register database service
        /** @var DatabaseServiceProvider $databaseServiceProvider */
        $databaseServiceProvider = (new DatabaseServiceProvider())->setContainer($this->container);
        $databaseServiceProvider();

        // Register controller object in container
        $this->container['App\Controllers\ExampleController'] = function($c) {
            return new ExampleController($c);
        };

        // Register model object in container
        $this->container['model'] = function($c) {
            return (new ExampleModel())->setContainer($c);
        };

        // Call next middleware
        return $next();
    }
}