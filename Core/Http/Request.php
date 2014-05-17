<?php 
namespace Core\Http;

/**
* HTTP request class.
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
	 * IP address of the current user.
	 * @var string
	 */
	private $ipAddress;

	/**
	 * Web browser being used by the current user.
	 * @var string
	 */
	private $userAgent;

    /**
	* Class constructor.
	*/
	public function __construct()
	{
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->requestMethod = $_SERVER['REQUEST_METHOD'];
		$this->fixUri();
	}

	/**
	 * This function will check URI and fix the query string
	 * if necessary.
	 */
	private function fixUri()
	{
		if (!isset($_SERVER['REQUEST_URI']) || !isset($_SERVER['SCRIPT_NAME'])) {
			return '';
		}

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
			$_GET = array();
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
	* Set request uri.
	* @param string
	*/
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
	* Get request method.
	* @return String
	*/
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
    * Check if it is AJAX request.	
    * @return boolean
    */
    public function isAjax()
    {
    	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    		return true;
		}
		return false;
    }

    /**
	* Get user agent.
	* @return string
	*/
	public function getUserAgent()
	{
		if (isset($this->userAgent)) {
			return $this->userAgent;
		}
		$this->userAgent = (!isset($_SERVER['HTTP_USER_AGENT'])) ? false : $_SERVER['HTTP_USER_AGENT'];

		return $this->userAgent;
	}

	/**
	* Get the user IP Address.
	* @return string
	*/
	public function getIpAddress()
	{
		if (isset($this->ipAddress)) {
			return $this->ipAddress;
		}
		$this->ipAddress = $_SERVER['REMOTE_ADDR'];
		return $this->ipAddress;
	}
}