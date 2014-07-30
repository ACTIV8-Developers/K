<?php 
namespace Core\Http;

/**
* HTTP request class.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Request
{
	/**
	* Request URI.
	* @var string 
	*/
	private $uri;
	
	/**
	* Request method
	* @var string
	*/
	private $requestMethod;

    /**
	* Class constructor.
	*/
	public function __construct()
	{
        // Get request method and URI
		$this->uri = $_SERVER['REQUEST_URI'];		
		$this->requestMethod = $_SERVER['REQUEST_METHOD'];
		
		// Fix URI if neeeded
        if (strpos($this->uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $this->uri = substr($this->uri, strlen($_SERVER['SCRIPT_NAME']));
        } elseif (strpos($this->uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $this->uri = substr($this->uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }

        // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
		// URI is found, and also fixes the QUERY_STRING server var and $_GET array.
		if (strncmp($this->uri, '?/', 2) === 0) {
			$this->uri = substr($this->uri, 2);
		}

        $parts = preg_split('#\?#i', $this->uri, 2);
        $this->uri = $parts[0];
        if (isset($parts[1])) {
            $_SERVER['QUERY_STRING'] = $parts[1];
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        } else {
            $_SERVER['QUERY_STRING'] = '';
            $_GET = [];
        }

		if ($this->uri == '/' || empty($this->uri)) {
			return '/';
		}

		$this->uri = parse_url($this->uri, PHP_URL_PATH);
		$this->uri = str_replace(array('//', '../'), '/', trim($this->uri, '/'));
	}

	/**
	* Get request uri.
	* @return string
	*/
    public function getUri()
    {
        return $this->uri;
    }

    /**
    * Get request URI segment.
    * @param int
    * @return string|bool
    */
    public function segment($num)
    {
    	$segments = explode('/', $this->uri);
    	if (isset($segments[$num])) {
    		return $segments[$num];
    	}
    	return false;
    }

    /**
	* Get request method.
    * (GET, POST, PUT, DELETE etc.)
	* @return String
	*/
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
    * Check if it is AJAX request.	
    * @return bool
    */
    public function isAjax()
    {
    	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    		return true;
		}
		return false;
    }

    /**
     * Get server protocol (eg. HTTP/1.1.)
     * @return string
     */
    public function getServerProtocol()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    /**
	* Get user agent.
	* @return string|bool
	*/
	public function getUserAgent()
	{
		return (!isset($_SERVER['HTTP_USER_AGENT'])) ? false : $_SERVER['HTTP_USER_AGENT'];
	}

	/**
	* Get the user IP Address.
	* @return string
	*/
	public function getUserIpAddress()
	{
		return $_SERVER['REMOTE_ADDR'];;
	}

    /**
	* Get Content Type
	* @return string|null
	*/
    public function getContentType()
    {
        return $_SERVER['CONTENT_TYPE'];
    }
}