<?php 
namespace Core\Session;

/**
* Session class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Session
{
	/**
	* Lifetime of the session cookie, defined in seconds.
	* @var int
	*/
	private $lifetime = 7200;

	/**
	* Used to restrict where the browser sends the cookie (Use a single slash ('/') for all paths on the domain. )
	* @var string
	*/
	private $path = '/';

	/**
	* If true the browser only sends the cookie over https
	* @var bool|null
	*/
	private $secure = null;// Let class decide
	
	/**
	* Cookie domain, for example 'www.php.net'. 
	* To make cookies visible on all subdomains then the domain must be prefixed with a dot like '.php.net'. 
	* @var string|null
	*/
	private $domain = "";

	/**
	* Marks the cookie as accessible only through the HTTP protocol. 
	* This means that the cookie won't be accessible by scripting languages, such as JavaScript. 
	* @var bool
	*/
	private $httponly = true;

	/**
	* @var bool
	*/
	private $matchIp = true;

	/**
	* Match user agent across session requests
	* @var bool
	*/
	private $matchUseragent = true;

	/**
	* Session name
	* @var string
	*/
	private $name = 'K';

	/**
	* Session storage system
	* @var string
	*/
	private $handler = 'file';

	/**
	* Table name if storage system is database
	* @var string
	*/
	private $tableName = 'sessions';

	/**
	* Period of refreshing session ID (0 is never)
	* @var int
	*/
	private $updateTime = 3;

	/**
	* Class construct
	* Register handler and start session here.
	*/
	public function __construct($params = [])
	{
		// Load configuration parameters
        foreach ($params as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }

		// Set session cookie name
		session_name($this->name.'_Session');

      	// Set the default secure value to whether the site is being accessed with SSL
      	$this->secure = $this->secure!==null ? $this->secure : isset($_SERVER['HTTPS']);

	    // Set the cookie settings
      	session_set_cookie_params($this->lifetime, $this->path, $this->domain, $this->secure, $this->httponly);

		// Select session handler
		if($this->handler==='file') {
			$handler = new \Core\Session\Handlers\FileSession();
		} elseif($this->handler==='database') {
			$handler = new \Core\Session\Handlers\DatabaseSession();
		}

		// Assign session handler
		session_set_save_handler($handler, true);

		// Start session
		session_start();

		// Validate session, if session is new or irregular clear data and start new session.
		if(!$this->validate()) {
			// Clear old session data
			$_SESSION = [];
			// Set session start time
            $_SESSION['time'] = strtotime("now");
			// Set new ip match if enabled
			if($this->matchIp) {
				$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
			}
			// Set new user agent match if enabled
			if($this->matchUseragent) {
				$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			}
		}

		// Regenerate session ID if enough time is passed
		if($this->updateTime!==0 && ((strtotime("now")-$_SESSION['time'])>$this->updateTime)) {
			// Reset timer
			$_SESSION['time'] = strtotime("now");
			// Regenerate session
			session_regenerate_id(true);
		}
	}

	/**
	* Validate session
	* @return bool
	*/
	private function validate()
	{
		if($this->matchIp && (!isset($_SESSION['IPaddress']) || $_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR']))
			return false;

		if($this->matchUseragent && $_SESSION['userAgent']!=$_SERVER['HTTP_USER_AGENT']
			&& !(strpos($_SESSION['userAgent'], ÔTridentÕ) !== false
			&& strpos($_SERVER['HTTP_USER_AGENT'], ÔTridentÕ) !== false))
			return false;

		if(empty($_SESSION['time']))
			return false;

		return true;
	} 
}