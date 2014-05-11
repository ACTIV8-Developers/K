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
    * The route callable (function or array path to certain controller). 
	* @var mixed
	*/
    private $callable;

    /**
    * @var List of parameters to be passed if URI is matched.
    */
    private $params = [];

    /**
    * @var List of conditions
    */
    private $conditions = [];

    /**
    * Regex used to parse routes.
    */
    const REGEX = '@:([\w]+)@';

    /**
	* Class constructor.
	* @param string
    * @param mixed
	* @param string
	*/
	public function __construct($url, $callable, $requestMethod = 'ANY')
	{
        $this->url = $url;
        $this->callable = $callable;
        $this->methods[] = $requestMethod;
	}

    /**
    *  Check if requested URI mathes this route.
    *  Design by: http://blog.sosedoff.com/2009/09/20/rails-like-php-url-router/
    * @param string
    * @param string
    * @return bool
    */
    public function matches($uri, $method)
    {
        if (in_array('ANY', $this->methods) || in_array($method, $this->methods)) {// Check request method
            $p_names = []; 
            $p_values = [];
            preg_match_all(self::REGEX, $this->url, $p_names, PREG_PATTERN_ORDER);
            $p_names = $p_names[0];
         
            $url_regex = preg_replace_callback(self::REGEX, [$this, 'regexUrl'], $this->url);
            $url_regex .= '/?';
         
            if (preg_match('@^'. $url_regex.'$@', $uri, $p_values)) {
                array_shift($p_values);
                foreach ($p_names as $index => $value) {
                    $this->params[substr($value, 1)] = urldecode($p_values[$index]);
                }
                return true;
            }
        return false;
        }
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
            return '([a-zA-Z0-9_\+\-%]+)';
        }
    }

    /**
    * Dispatch route to assigned controller/function.
    * All files including subfodlers in APP/Controller
    * will be considered for dispatch.
    */
    public function dispatch()
    {   
        // Check if callable function or controller path
        if(false==$this->callable[1]) { // false is passed as second argument instead of function name
            $this->callable[0]($this->params);
        } else { // If it's not callable try to route to controller/action
            // Require controller
            require APP.'Controllers/'.$this->callable[0].'.php';
            // Exctract exact controller name
            $controller = explode('/', $this->callable[0]);
            $controller = end($controller);
            // Create controller
            call_user_func_array([new $controller(), $this->callable[1]], $this->params);
        }
    }

    /**
	* Set supported HTTP method(s)
	*/
 	public function setHttpMethods($method)
    {
        $this->methods = $method;
    }

    /**
	* Get supported HTTP method(s)
	* @return array
	*/
    public function getHttpMethods()
    {
        return $this->methods;
    }

	/**
	* Get route URL
	* @return string
	*/
    public function getUrl()
    {
        return $this->url;
    }

    /**
	* Set route url
	* @param string $pattern
	*/
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
	* Get route callable
	* @return mixed
	*/
    public function getCallable()
    {
        return $this->callable;
    }

    /**
	* Set route callable
	* @param mixed $callable
	*/
    public function setCallable($callable)
    {
        $this->callable = $callable;
    }
}
