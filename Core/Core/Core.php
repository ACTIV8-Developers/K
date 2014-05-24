<?php 
namespace Core\Core;

use \Core\Util\Container;
use \Core\Http\Request;
use \Core\Http\Input;
use \Core\Http\Response;
use \Core\Session\Session;
use \Core\Database\Database;

/**
* Core class of Core. This class is a container for all objects
* of application, it is implemented as singleton, also main run method
* with session, routing, database connection etc. is defined here.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
* @see Dependecy Injection Container
* @see Singleton
*/
class Core extends Container
{
    /**
    * Core version.
    */
    const VERSION = '1.0';

    /**
    * Singleton instance of Core.
    * @var object
    */
    private static $instance = null;

    /**
	* Class constructor.
    * Loads all needed classes closures into container.
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
                switch($dbConfig['driver']) {
                    case 'mysql':
                        // Create connection with passed settings
                        $db = new \Core\Database\Connections\MySQLConnection($dbConfig);
                        // Inject it into database class
                        return new Database($db->getConnection());
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
            switch($c['config']['sessionHandler']) {
                case 'file':
                    $handler = new \Core\Session\Handlers\FileSession();
                    break;
                case 'database':
                    $handler = new \Core\Session\Handlers\DatabaseSession();
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
        // Pre system hooks

        // Load and start session if enabled in configuration
        if ($this['config']['sessionStart']) {
            $this['session'];
        }

        // Collect routes list from file.
        require ROUTES;

        // Pre routing/controller hooks (must be enabled in configuration)
        if ($this['config']['languages']) {
            \Util::extractLanguage($this['config']['languages'], $this['request']->getUri());
        }

        // Route requests
        if(!$this['router']->run($this['request'])) {
            // If no route found send and show 404
            $this->show404();
        }

        // Post routing/controller hooks

        // Display final response
        $this['response']->display();

        // Post system hooks

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
}