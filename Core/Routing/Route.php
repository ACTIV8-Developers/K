<?php
namespace Core\Routing;

/**
* Route class. 
* This class represents single route.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Route
{
  	/**
    * The route pattern (The URL pattern (e.g. "article/:year/:category")).
	* @var string 
	*/
	public $url = '';

    /**
    * The route callable 
    * (name of controller and function to execute e.g ['ExampleController', 'index']).
	* @var array
	*/
    public $callable = [];

    /**
    * List of parameters to be passed if URL is matched.
    * @var array
    */
    public $params = [];

    /**
    * List of supported HTTP methods for this route.
    * @var array
    */
    protected $methods = [];
    
    /**
    * List of parameters conditions.
    * @var array
    */
    protected $conditions = [];

    /**
    * List of regex to use when matching conditions.
    * @param array
    */
    protected static $conditionRegex = [
                        'default'           => '[a-zA-Z0-9_\-]+', // Default allows letters, numbers, underscores and dashes.
                        'alpha-numeric'     => '[a-zA-Z0-9]+', // Numbers and letters.
                        'numeric'           => '[0-9]+', // Numbers only.
                        'alpha'             => '[a-zA-Z]+', // Letters only.
                        'alpha-lowercase'   => '[a-z]+',  // All lowercase letter.
                        'real-numeric'      => '[0-9\.\-]+' // Numbers, dots or minus signs.
                    ];

    /**
    * Regex used to parse routes.
    * @var string
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
    * Inspired by: http://blog.sosedoff.com/2009/09/20/rails-like-php-url-router/
    * @param string
    * @param string
    * @return bool
    */
    public function matches($uri, $method)
    {
        // Check if request method matches.
        if (in_array($method, $this->methods) || in_array('ANY', $this->methods)) {        
            $paramValues = [];

            // Replace parameters with proper regex patterns.
            $urlRegex = preg_replace_callback(self::MATCHES_REGEX, [$this, 'regexUrl'], $this->url);

            // Check if URI matches and if it matches put results in values array.
            if (preg_match('@^'.$urlRegex.'/?$@', $uri, $paramValues) === 1) {// There is a match.
                // Extract parameter names.
                $paramNames = []; 
                preg_match_all(self::MATCHES_REGEX, $this->url, $paramNames, PREG_PATTERN_ORDER);

                // Put parameters to array to be passed to controller/function later.
                foreach ($paramNames[0] as $index => $value) {
                    $this->params[substr($value, 1)] = urldecode($paramValues[$index + 1]);
                }
                // Everything is done return true.
                return true;
            }
        }
        // No match found return false.
        return false;
    }

    /**
    * Helper regex for matches function.
    * @param string
    * @return string
    **/
    protected function regexUrl($matches) 
    {
        $key = substr($matches[0], 1);
        if (isset($this->conditions[$key])) {
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
    * Set route custom parameter condition.
    * @param string
    * @param string
    * @return object \Core\Core\Route (for method chaining)
    */
    public function whereRegex($key, $pattern)
    {
        $this->conditions[$key] = $pattern;
        return $this;
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
}