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
    * The route callable (name of controller and function to execute).
	* @var array
	*/
    private $callable;

    /**
    * List of parameters to be passed if URI is matched.
    * @var array
    */
    private $params = [];

    /**
    * List of conditions.
    * @var array
    */
    private $conditions = [];

    /**
    * Regex used to parse routes.
    */
    const REGEX = '@:([\w]+)@';

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
            return '([a-zA-Z0-9_\+\-%]+)';
        }
    }

    /**
    * Dispatch route to assigned controller/function.
    */
    public function dispatch()
    {
        // Require controller
        require APP.'Controllers/'.$this->callable[0].'.php';
        // Extract exact controller name
        $controller = explode('/', $this->callable[0]);
        $controller = end($controller);
        // Create controller
        call_user_func_array([new $controller(), $this->callable[1]], $this->params);
    }

    /**
     * Add GET as acceptable method.
     */
    public function viaGet()
    {
        $this->methods[] = 'GET';
    }

    /**
     * Add POST as acceptable method.
     */
    public function viaPost()
    {
        $this->methods[] = 'POST';
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
}
