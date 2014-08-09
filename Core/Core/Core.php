<?php 
namespace Core\Core;

use \Core\Http\Request;
use \Core\Http\Cookies;
use \Core\Http\Input;
use \Core\Http\Response;
use \Core\Routing\Router;
use \Core\Session\Session;
use \Core\Database\Database;

/**
* Core class.
* This is the heart of whole framework. It is a singleton container for all main 
* objects of application. This class containes main 
* run method which executes all functions in life cycle of application.
* 
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Core extends Container
{
    /**
    * Core version.
    * @var string
    */
    const VERSION = '1.2';

    /**
    * Singleton instance of Core.
    * @var object
    */
    private static $instance = null;

    /**
    * Array of hooks to be applied.
    * @var array
    */
    private $hooks = [
        'before.routing' => null, 
        'after.routing'=> null
    ];

    /**
	* Class constructor.
    * Loads all needed classes as closures into container.
    * @throws \InvalidArgumentException
	*/
   	protected function __construct()
    {
        // Call parent container constructor.
        parent::__construct();

        // Load configuration.
        $this['config'] = require APP.'Config/Config.php';

        // Create request class closure.
        $this['request'] = function() {
            return new Request($_SERVER);
        };

        // Create router class closure.
        $this['router'] = function() { 
            return new Router();
        };  

        // Create input class closure.
        $this['input'] = function() {
            return new Input();
        };

        // Create cookies class closure.
        $this['cookies'] = function($c) {
            return new Cookies($c['config']['cookies']);
        };

        // Create response class closure.
        $this['response'] = function($c) {
            $response = new Response();
            $response->setProtocolVersion($c['request']->getProtocolVersion());
            return $response;
        }; 

        // Load database settings.
        $databaseList = require APP.'Config/Database.php';

        // For each needed database create database class closure.
        foreach ($databaseList as $name => $dbConfig) {
            $this['db'.$name] = function() use ($dbConfig) {
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
        $this['session'] = function($c) {
            // Select session handler.
            $handler = null;
            switch ($c['config']['sessionHandler']) {
                case 'file':
                    $handler = new \Core\Session\Handlers\FileSessionHandler();
                    break;
                case 'database':
                    $handler = new \Core\Session\Handlers\DatabaseSessionHandler();
                    break;
            }

            return new Session($c['config']['session'], $handler);
        };
    }
    
    /**
    * Core main executive function.
    * Function will start session, connect to database, apply hooks,
    * route requests, execute controllers and display response.
    */        
    public function run()
    {
        // Load and start session if enabled in configuration.
        if ($this['config']['sessionStart']) {
            $this['session']->start();
        }

        // Collect routes list from file.
        require ROUTES;

        // Pre routing/controller hooks.
        if (is_callable($this->hooks['before.routing'])) {
            call_user_func($this->hooks['before.routing'], $this);
        }

        // Route requests
        if (!$this['router']->run($this['request']->getUri(), $this['request']->getRequestMethod())) {
            // If no route found send and show 404.
            $this->show404();
        }

        // Post routing/controller hooks.
        if (is_callable($this->hooks['after.routing'])) {
            call_user_func($this->hooks['after.routing'], $this);
        }

        // Send final response.
        $this['response']->send();

        // Display benchmark time if enabled.
        if ($this['config']['benchmark']) {
            print \PHP_Timer::resourceUsage();
        }
    }  

    /**
    * Get singleton instance of Core class.
    * @return object \Core\Core\Core
    */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Core();
        }
        return self::$instance;
    }

    /*
    * Display 404 page.
    */
    private function show404()
    {
        $this['response']->setStatusCode(404);
        $this['response']->setBody('<h1>404 Not Found</h1>The page that you have requested could not be found.');
    }

    /**
    * Add hook.
    * @param string
    * @param callable
    */
    public function hook($key, $callable) 
    {
        $this->hooks[$key] = $callable;
    }

    /**
    * Get hook.
    * @param string
    * @return callable
    */
    public function getHook($key) 
    {
        return $this->hooks[$key];
    }
}