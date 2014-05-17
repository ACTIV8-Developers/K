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
	public function run($request)
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

	    // If no route found show 404
	    if(!$found) {
	    	$this->show404();
	    }
	}

    /**
	* Add a route object to the router accepting any request method.
	* @param string
	* @param mixed
	*/
    public static function any($url, $callable)
    {
    	$route = new Route($url, $callable);
		self::$routes[] = $route;
    }

    /**
	* Add a route object to the router accepting GET request method.
	* @param string 
	* @param mixed
	*/
    public static function get($url, $callable)
    {
    	$route = new Route($url, $callable, 'GET');
		self::$routes[] = $route;
    }

    /**
	* Add a route object to the router accepting POST request method.
	* @param string
	* @param mixed
	*/
    public static function post($url, $callable)
    {
    	$route = new Route($url, $callable, 'POST');
		self::$routes[] = $route;
    }

    /**
	* Add a route object to the router accepting PUT request method.
	* @param string
	* @param mixed
	*/
    public static function put($url, $callable)
    {
    	$route = new Route($url, $callable, 'PUT');
		self::$routes[] = $route;
    }

    /**
	* Add a route object to the router accepting DELETE request method.
	* @param string $url
	* @param mixed $callable
	*/
    public static function delete($url, $callable)
    {
    	$route = new Route($url, $callable, 'DELETE');
		self::$routes[] = $route;
    }

    /*
    * Display 404 page.
    */
    private function show404()
    {
    	// TO DO make better page display
    	echo '404 for request:';
    }
}