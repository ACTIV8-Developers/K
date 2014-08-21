<?php
namespace Core\Http;

/**
* Cookies class.
* 
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Cookies
{
	/**
	* Used to restrict where the browser sends the cookie (Use a single slash ('/') for all paths on the domain. )
	* @var string
	*/
	private $path = '/';

	/**
	* Cookie domain, for example 'www.php.net'. 
	* To make cookies visible on all sub domains then the domain must be prefixed with a dot like '.php.net'.
	* @var string|null
	*/
	private $domain = '';

	/**
	* If true the browser only sends the cookie over https.
	* Null denotes class will decide.
	* @var bool
	*/
	private $secure = false;

	/**
	* Marks the cookie as accessible only through the HTTP protocol. 
	* This means that the cookie won't be accessible by scripting languages, such as JavaScript. 
	* @var bool
	*/
	private $httponly = true;

	public function __construct(array $params = [])
	{
      	// Set the domain to default or to the current domain.
      	$this->domain = isset($this->domain) ? $this->domain : isset($_SERVER['SERVER_NAME']);

		// Load configuration parameters
        foreach ($params as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }
	}

	/**
	* Set cookie.
	* @param string
	* @param string
	* @param int
	* @param string
	* @param bool
	* @param bool
	*/
	public function set($key, $value, $expiration = 7200, $domain = null, $secure = null, $httponly = null)
	{
		if ($expiration === null) {
			$expiration = $this->expiration;
		}
		if ($domain === null) {
			$domain = $this->domain;
		}
		if (!$secure === null) {
			$secure = $this->secure;
		}
		if (!$httponly === null) {
			$httponly = $this->httponly;
		}
		setcookie($key, $value, time() + $expiration, $domain, $secure, $httponly);
	}

	/**
	* Get cookie.
	* @param string
	* @return string
	*/
	public function get($key)
	{
		return $_COOKIE[$key];
	}
}