<?php 
namespace Core\Routing;

/**
* Router class.
*
* This class contains list of application routes,
* also here are methods for adding things to list and
* here is defined run method for routing requests.
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
	* Check routes and dispatch matching one if found.
	* @var string
    * @var string
	* @return bool
	*/
	public function run($uri, $requestMethod)
	{
		// Dispatch correct route
	    foreach (self::$routes as $route) {
	    	if (true === $route->matches($uri, $requestMethod)) {
	        	$route->dispatch();
	        	return true;
	      	}
	    }
	    return false;
	}

    /**
	* Add a route object to the router accepting any request method.
	* @param string
	* @param array
    * @return object \Core\Routing\Route
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
    * @return object \Core\Routing\Route
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
    * @return object \Core\Routing\Route
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
    * @return object \Core\Core\Route
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
    * @return object \Core\Core\Route
	*/
    public static function delete($url, $callable)
    {
    	$route = new Route($url, $callable, 'DELETE');
		self::$routes[] = $route;
        return $route;
    }

    /**
    * Add custom route object to routes array.
    * @var object \Core\Core\Route
    */
    public static function addRoute(Route $route)
    {
    	self::$routes[] = $route;
    }

    /**
     * Get list of routes.
     * @return array
     */
    public static function getRoutes()
    {
        return self::$routes;
    }
}