<?php 
namespace Core\Core;

/**
* Router class, it contains list of application routes,
* also here are methods for adding things to list and
* finally here is defined run method for routing requests.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Router
{
	/**
	* Collection of routes.
	* @var array
	**/
	private static $routes = [];

	/**
	* Check routes and dispatch matching one.
	* @var object Core\Http\Request
	*/
	public function run(\Core\Http\Request $request)
	{
		$found = false;
		// Get parameters to check against
		$resourceUri = $request->getUri();
		$requestMethod = $request->getRequestMethod();
		// Dispatch correct route
	    foreach (self::$routes as $route) {
	    	if (true===$route->matches($resourceUri, $requestMethod)) {
	        	$route->dispatch();
	        	$found = true;
	        	break;
	      	}
	    }

	    // If no route found send and show 404
	    if(!$found) {
	    	$this->show404();
	    }
	}

    /**
	* Add a route object to the router accepting any request method.
	* @param string
	* @param array
    * @return object /Core/Route
	*/
    public static function any($url, $callable)
    {
    	$route = new Route($url, $callable);
		self::$routes[] = $route;
        return $route;
    }

    /**
	* Add a route object to the router accepting GET request method.
	* @param string 
	* @param array
    * @return object Core\Route
    */
    public static function get($url, $callable)
    {
    	$route = new Route($url, $callable, 'GET');
		self::$routes[] = $route;
        return $route;
    }

    /**
	* Add a route object to the router accepting POST request method.
	* @param string
	* @param array
    * @return object /Core/Route
    */
    public static function post($url, $callable)
    {
    	$route = new Route($url, $callable, 'POST');
		self::$routes[] = $route;
        return $route;
    }

    /**
	* Add a route object to the router accepting PUT request method.
	* @param string
	* @param array
    * @return object /Core/Route
	*/
    public static function put($url, $callable)
    {
    	$route = new Route($url, $callable, 'PUT');
		self::$routes[] = $route;
        return $route;
    }

    /**
	* Add a route object to the router accepting DELETE request method.
	* @param string
	* @param array
    * @return object /Core/Route
	*/
    public static function delete($url, $callable)
    {
    	$route = new Route($url, $callable, 'DELETE');
		self::$routes[] = $route;
        return $route;
    }

    /*
    * Display 404 page.
    */
    private function show404()
    {
    	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    	echo "<h1>404 Not Found</h1>";
	    echo "The page that you have requested could not be found.";
	    exit();
    }
}