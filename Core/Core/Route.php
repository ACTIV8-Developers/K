<?php
namespace Core\Core;

/**
* Route class represents single route and contains method
* for self dispatching if passed parameters are matched.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Route
{
  	/**
    * The route pattern (The URL pattern (e.g. "/article/:id")).
	* @var string 
	*/
	private $url;

  	/**
    * List of supported HTTP methods for route.
	* @var array
	*/
	private $methods = [];

    /**
    * The route callable 
    * (name of controller and function to execute e.g ['ExampleController', 'index']).
	* @var array
	*/
    private $callable;

    /**
    * List of parameters to be passed if URI is matched.
    * @var array
    */
    private $params = [];

    /**
    * List of parameters conditions.
    * @var array
    */
    private $conditions = [];

    /**
    * List of regex to use when matching conditions.
    * @param array
    */
    private static $conditionRegex = [
                        'default'           => '[a-zA-Z0-9_\-]+', // Default allows letters, numbers, underscores and dashes.
                        'alpha-numeric'     => '[a-zA-Z0-9]+', // Numbers and letters.
                        'numeric'           => '[0-9]+', // Numbers only.
                        'alpha'             => '[a-zA-Z]+', // Letters only.
                        'alpha-lowercase'   => '[a-z]+',  // All lowercase letter.
                        'real-numeric'      => '[0-9\.\-]+' // Numbers, dots or minus signs.
                    ];

    /**
    * Regex used to parse routes.
    */
    const MATCHES_REGEX = '@:([\w]+)@';

    /**
	* Class constructor.
	* @param string
    * @param array
	* @param string
	*/
	public function __construct($url, $callable, $requestMethod = 'ANY')
	{
        $this->url = $url;
        $this->callable = $callable;
        $this->methods[] = $requestMethod;
	}

    /**
    * Check if requested URI matches this route.
    * Design by: http://blog.sosedoff.com/2009/09/20/rails-like-php-url-router/
    * @param string
    * @param string
    * @return bool
    */
    public function matches($uri, $method)
    {
        if (in_array('ANY', $this->methods) || in_array($method, $this->methods)) {
            $p_names = []; 
            $p_values = [];
            preg_match_all(self::MATCHES_REGEX, $this->url, $p_names, PREG_PATTERN_ORDER);
            $p_names = $p_names[0];
         
            $url_regex = preg_replace_callback(self::MATCHES_REGEX, [$this, 'regexUrl'], $this->url);
            $url_regex .= '/?';
         
            if (preg_match('@^'. $url_regex.'$@', $uri, $p_values)) {
                array_shift($p_values);
                foreach ($p_names as $index => $value) {
                    $this->params[substr($value, 1)] = urldecode($p_values[$index]);
                }
                return true;
            }
        }
        return false;
    }

    /**
    * Helper regex for matches function.
    * @param string
    * @return string
    **/
    private function regexUrl($matches) 
    {
        $key = str_replace(':', '', $matches[0]);
        if (array_key_exists($key, $this->conditions)) {
            return '('.$this->conditions[$key].')';
        } else {
            return '('.self::$conditionRegex['default'].')';
        }
    }

    /**
    * Set route parameter condition.
    * @param string
    * @param string
    * @return object \Core\Core\Route (for method chaining)
    */
    public function where($key, $condition)
    {
        $this->conditions[$key] = self::$conditionRegex[$condition];
        return $this;
    }

    /**
    * Dispatch route to assigned controller/function.
    */
    public function dispatch()
    {
        // Create controller
        $controller = CONTROLERS."\\".$this->callable[0];
        call_user_func_array([new $controller(), $this->callable[1]], $this->params);
    }

    /**
    * Add GET as acceptable method.
    * @return object \Core\Core\Route (for method chaining)
    */
    public function viaGet()
    {
        $this->methods[] = 'GET';
        return $this;
    }

    /**
    * Add POST as acceptable method.
    * @return object \Core\Core\Route (for method chaining)
    */
    public function viaPost()
    {
        $this->methods[] = 'POST';
        return $this;
    }

    /**
    * Get supported HTTP method(s).
    * @return array
    */
    public function getHttpMethods()
    {
        return $this->methods;
    }

    /**
    * Get route URL.
    * @return string
    */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get name of controller and method to call.
     * @return array
     */
    public function getCallable()
    {
        return $this->callable;
    }
}
