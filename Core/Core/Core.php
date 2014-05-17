<?php 
namespace Core\Core;

use \Core\Util\Container;
use \Core\Http\Request;
use \Core\Http\Input;
use \Core\Http\Response;
use \Core\Session\Session;
use \Core\Database\Database;
use \Core\Errors\Log;

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
    * @const string
    */
    const VERSION = '0.98';

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
        $this['request'] = function () {
            return new Request();
        };

        // Create input class.
        $this['input'] = function () {
            return new Input();
        };

        // Create response class.
        $this['response'] = function () {
            return new Response();
        }; 

		// Create router class.
		$this['router'] = function () { 
            return new Router();
        };	

        // Create database class.
        $this['database'] = function() {
            // Create connection with passed settings
            $db = new \Core\Database\Connections\MySQLConnection(require APP.'Config/Database.php');
            // Inject it into database class
            return new Database($db->getConnection());
        };  

        // Create session class.
        $this['session'] = function ($c) {
            return new Session($c['config']['sessionAndCookies']);
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
        if($this['config']['sessionStart']) {
            $this['session'];
        }

        // Collect routes list from file.
        require ROUTES;

        // Pre routing/controller  hooks (must be enabled in configuration)
        if($this['config']['languages']) {
            \Util::extractLanguage($this['config']['languages'], $this['request']->getUri());
        }

        // Route requests
        $this['router']->run($this['request']);

        // Post routing/controller hooks

        // Write log if enabled in config
        if($this['config']['logWrite']) {
            \Error::writeLog();
        }

        // Append log to display if enabled
        if($this['config']['logDisplay']) {
            $this['response']->appendBody(\Error::displayLog());
        }

        // Display final response
        $this['response']->display();

        // Display benchmark time if enabled
        if($this['config']['benchmark']) {
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
}