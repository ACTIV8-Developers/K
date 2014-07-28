<?php 
namespace Core\Core;

use \Core\Http\Request;
use \Core\Routing\Router;
use \Core\Http\Input;
use \Core\Http\Response;
use \Core\Session\Session;
use \Core\Database\Database;

/**
* Core class is the heart of whole framework. This class is a container for all main 
* objects of application, it is implemented as singleton. This class containes main 
* run method which executes all functions in life cycle of application.
* 
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Core extends Container
{
    /**
    * @const string
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
	**/
   	public function __construct()
    {
        // Call container parent constructor
        parent::__construct();

        // Load configuration
        $this['config'] = require APP.'Config/Config.php';

        // Create request
        $this['request'] = function() {
            return new Request();
        };

        // Create input class.
        $this['input'] = function() {
            return new Input();
        };

        // Create response class.
        $this['response'] = function() {
            return new Response();
        }; 

		// Create router class.
		$this['router'] = function() { 
            return new Router();
        };	

        // Load database settings
        $databaseList = require APP.'Config/Database.php';

        // For each needed database create connection closure
        foreach ($databaseList as $name => $dbConfig) {
            $this['db'.$name] = function() use ($dbConfig) {
                switch ($dbConfig['driver']) {
                    case 'mysql':
                        // Create connection with passed settings
                        $db = new \Core\Database\Connections\MySQLConnection($dbConfig);
                        // Inject it into database class
                        return new Database($db);
                    default:
                        throw new \InvalidArgumentException('Error! Unsupported database driver type.');
                        break;
                }
            };  
        }

        // Create session class.
        $this['session'] = function($c) {
            // Select session handler
            $handler = null;
            switch ($c['config']['sessionHandler']) {
                case 'file':
                    $handler = new \Core\Session\Handlers\FileSessionHandler();
                    break;
                case 'database':
                    $handler = new \Core\Session\Handlers\DatabaseSessionHandler();
                    break;
            }

            return new Session($c['config']['sessionAndCookies'], $handler);
        };
    }
    
    /**
    * Main executive function of Core class.
    * Function will start session, connect to database, apply hooks,
    * route requests, execute controllers and display response.
    */        
    public function run()
    {
        // Load and start session if enabled in configuration
        if ($this['config']['sessionStart']) {
            $this['session'];
        }

        // Collect routes list from file.
        require ROUTES;

        // Pre routing/controller hooks
        if (is_callable($this->hooks['before.routing'])) {
            call_user_func($this->hooks['before.routing'], $this);
        }

        // Route requests
        if (!$this['router']->run($this['request'])) {
            // If no route found send and show 404
            $this->show404();
        }

        // Post routing/controller hooks
        if (is_callable($this->hooks['after.routing'])) {
            call_user_func($this->hooks['after.routing'], $this);
        }

        // Send final response
        $this['response']->display();

        // Display benchmark time if enabled
        if ($this['config']['benchmark']) {
            print \PHP_Timer::resourceUsage();
        }
    }  

    /**
    * Get singleton instance of Core class.
    * @return object
    */
    public static function getInstance()
    {
        if (null===self::$instance) {
            self::$instance = new Core();
        }
        return self::$instance;
    }

    /*
    * Display 404 page.
    */
    private function show404()
    {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        $this['response']->setBody('<h1>404 Not Found</h1>The page that you have requested could not be found.');
    }

    /**
    * Add hook
    * @param string
    * @param callable
    */
    public function hook($key, $callable) 
    {
        $this->hooks[$key] = $callable;
    }

    /**
    * Get hook
    * @param string
    * @return callable
    */
    public function getHook($key) 
    {
        return $this->hooks[$key];
    }
}