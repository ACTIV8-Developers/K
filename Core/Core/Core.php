<?php 
namespace Core\Core;

use \Core\Http\Request;
use \Core\Http\Response;
use \Core\Routing\Router;
use \Core\Session\Session;
use \Core\Database\Database;

/**
* Core class.
* This is the heart of whole framework. It is a singleton container for all main 
* objects of application. This class containes main 
* run method which handles life cycle of application.
* 
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Core extends \Pimple\Container
{
    /**
    * Core version.
    *
    * @var string
    */
    const VERSION = '1.3';

    /**
    * Singleton instance of Core.
    *
    * @var object
    */
    protected static $instance = null;

    /**
    * Array of hooks to be applied.
    *
    * @var array
    */
    protected $hooks = [
        'before.system'  => null, 
        'before.routing' => null, 
        'after.routing'  => null,
        'after.system'   => null,
        'not.found'      => null
    ];

    /**
    * Class constructor.
    * Prepares all needed classes.
    *
    * @throws \InvalidArgumentException
    */
    public function __construct()
    {
        // Call parent container constructor.
        parent::__construct();

        // Load application configuration.
        $this['config'] = require APP.'Config/Config.php';

        // Create request class closure.
        $this['Request'] = function() {
            return new Request($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
        }; 

        // Create response class closure.
        $this['Response'] = function($c) {
            $response = new Response();
            $response->setProtocolVersion($c['Request']->getProtocolVersion());
            return $response;
        };

        // Load database configuration.
        $this['config.database'] = require APP.'Config/Database.php';

        // For each needed database create database class closure.
        foreach ($this['config.database'] as $name => $dbConfig) {
            $this['db'.$name] = function($c) use ($dbConfig) {
                $db = null;
                switch ($dbConfig['driver']) { // Choose connection and create it.
                    case 'mysql':               
                        $db = new \Core\Database\Connections\MySQLConnection($dbConfig);
                        break;
                    default:
                        throw new \InvalidArgumentException('Error! Unsupported database connection type.');
                }
                // Inject it into database class.
                return new Database($db->connect());
            };  
        }

        // Create session class closure.
        $this['Session'] = function($c) {
            // Select session handler.
            $handler = null;
            switch ($c['config']['sessionHandler']) {
                case 'encrypted-file':
                    $handler = new \Core\Session\Handlers\EncryptedFileSessionHandler();
                    break;
                case 'database':
                    $name = $c['config']['session']['connName'];
                    $conn = $this['db'.$name]->getConnection();
                    $handler = new \Core\Session\Handlers\DatabaseSessionHandler();
                    break;
                case 'redis':
                    try {
                        $db = new \Predis\Client($c['config']['redis']);
                        $handler = new \Core\Session\Handlers\RedisSessionHandler($db);
                        $handler->prefix = $c['config']['session']['name'];
                        $handler->expire = $c['config']['session']['expiration'];
                    } catch(\Exception $e) {
                        throw new \InvalidArgumentException('Error! Cannot connect to Redis server. '.$e->getMessage());
                    }
                    break;
            }
            $session = new Session($c['config']['session'], $handler);
            $session->setHashKey($c['config']['key']);
            return $session;
        };
    }
    
    /**
    * Application main executive function.
    */        
    public function run()
    {
        try {    
            // Pre routing/controller hook.
            if (isset($this->hooks['before.system'])) {
                call_user_func($this->hooks['before.system'], $this);
            }

            // Load and start session if enabled in configuration.
            if ($this['config']['sessionStart']) {
                $this['Session']->start();
            }

            // Execute routing.
            $this->routeRequest();
        } catch (\Exception $e) {
            
        }

        // Post routing/controller hook.
        if (isset($this->hooks['after.routing'])) {
            call_user_func($this->hooks['after.routing'], $this);
        }

        // Send final response.
        $this['Response']->send();

        // Display benchmark time if enabled.
        if ($this['config']['benchmark']) {
            print \PHP_Timer::resourceUsage();
        }

        // Post response hook.
        if (isset($this->hooks['after.system'])) {
            call_user_func($this->hooks['after.system'], $this);
        }
    }  

    /**
    * Route request and execute proper controller if route found.
    */
    protected function routeRequest()
    {
        // Create router instance.
        $route = new Router();

        // Collect routes list from file.
        include ROUTES;

        // Pre routing/controller hook.
        if (isset($this->hooks['before.routing'])) {
            call_user_func($this->hooks['before.routing'], $this);
        }

        // Route requests
        $matchedRoute = $route->run($this['Request']->getUri(), $this['Request']->getRequestMethod());
        
        // Execute route if found.
        if (false !== $matchedRoute) {
            $this['Request']->get->replace($matchedRoute->params);
            $matchedRoute->params = array_values($matchedRoute->params);

            // Get controller name with namespace prefix.
            $matchedRoute->callable[0] = CONTROLERS.'\\'.$matchedRoute->callable[0];

            // Create instance of controller to be called.
            $controller = new $matchedRoute->callable[0];
            
            // Inject container into controller.
            $controller->setContainer(self::$instance);

            // Try to resolve controller dependecies if enabled.
            if ($this['config']['injectDependecies'] === true) {
                // Get controller methods using reflection.
                $classMethod = new \ReflectionMethod($matchedRoute->callable[0], $matchedRoute->callable[1]);

                $methods = $classMethod->getParameters();

                $params = [];

                $num = 0;

                foreach ($methods as $method) {
                    $export = \ReflectionParameter::export(
                       [
                          $method->getDeclaringClass()->name,
                          $method->getDeclaringFunction()->name
                       ], 
                       $method->name, 
                       true
                    );

                    $type = preg_replace('/.*?(\w+)\s+\$'.$method->name.'.*/', '\\1', $export);

                    if (isset($this[$type])) {
                        $params[] = $this[$type];
                    } else {
                        $params[] = $matchedRoute->params[$num++];
                    }
                }
                call_user_func_array([$controller, $matchedRoute->callable[1]], $params);
            } else {
                call_user_func_array([$controller, $matchedRoute->callable[1]], $matchedRoute->params);
            }
        } else {
            // If page not found display 404 error.
            if (isset($this->hooks['not.found'])) {
                call_user_func($this->hooks['not.found'], $this);
            } else {
                $this->defaultNotFound();
            }
        }
    }

    /**
    * Default handler for 404 error.
    */
    protected function defaultNotFound()
    {
        $this['Response']->setStatusCode(404);
        $this['Response']->setBody('<h1>404 Not Found</h1>The page that you have requested could not be found.');
    }

    /**
    * Get singleton instance of Core class.
    *
    * @return object \Core\Core\Core
    */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Core();
        }
        return self::$instance;
    }

    /**
    * Add hook.
    *
    * @param string
    * @param callable
    */
    public function setHook($key, $callable) 
    {
        $this->hooks[$key] = $callable;
    }

    /**
    * Get hook.
    *
    * @param string
    * @return callable
    */
    public function getHook($key) 
    {
        return $this->hooks[$key];
    }
}