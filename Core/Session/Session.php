<?php 
namespace Core\Session;

/**
* Session manager class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Session
{
    /**
     * Encryption key.
     * @var string
     */
    private $hashKey = 'super_secret';

	/**
	* Lifetime of the session cookie and session duration, defined in seconds.
	* @var int
	*/
	private $expiration = 7200;

	/**
	* Cookie domain, for example 'www.php.net'. 
	* To make cookies visible on all sub domains then the domain must be prefixed with a dot like '.php.net'.
	* @var string|null
	*/
	private $domain = '';

	/**
	* If true the browser only sends the cookie over HTTPS.
	* Null denotes class will decide.
	* @var bool|null
	*/
	private $secure = null;

	/**
	* Session name.
	* @var string
	*/
	private $name = 'PHPSESS';

	/**
	* Session storage system.
	* @var string
	*/
	private $handler = 'file';

	/**
	* Match user agent across session requests.
	* @var bool
	*/
	private $matchUserAgent = true;

	/**
	* Period of refreshing session ID.
	* @var int
	*/
	private $updateFrequency = 10;

	/**
	* Class construct.
	* Register handler and start session here.
	* @param array
	* @param object \SessionHandlerInterface
	*/
	public function __construct(array $params = [], \SessionHandlerInterface $handler = null)
	{
		// Load configuration parameters.
        foreach ($params as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }

		// Set session cookie name.
		session_name($this->name.'');

      	// Set the default secure value to whether the site is being accessed with SSL.
      	$this->secure = $this->secure !== null ? $this->secure : isset($_SERVER['HTTPS']);

      	// Set the domain to default or to the current domain.
      	$this->domain = isset($this->domain) ? $this->domain : isset($_SERVER['SERVER_NAME']);

	    // Set the cookie settings.
      	session_set_cookie_params($this->expiration, '/', $this->domain, $this->secure, true);

		// Select session handler.
		if ($handler !== null) {
			// Assign session handler.
			session_set_save_handler($handler, true);
		}
	}

	/**
	* Start session.
	*/
	public function start()
	{
		// If no active session start one.
	    if (session_status() !== PHP_SESSION_ACTIVE) { 
	        session_start(); 
	    } 

		// Validate session, if session is new or irregular clear data and start new session.
		if (!$this->validate()) {
			$this->regenerate();
        }

		// Regenerate session ID cycle
		if (mt_rand(1, 100)<$this->updateFrequency) {
			// Regenerate session
			session_regenerate_id();
		}
	}

	/**
	* Validate session.
	* @return bool
	*/
	private function validate()
	{
		// Are needed session variables set ?
		if (!isset($_SESSION['s3ss10nCr3at3d']) || !isset($_SESSION['n3k0t'])) {
			return false;
		}

		// Check if session token match ?
		if ($this->matchUserAgent) {
			if ($_SESSION['n3k0t'] != hash_hmac('sha256', $_SERVER['HTTP_USER_AGENT'].$_SESSION['s3ss10nCr3at3d'], $this->hashKey)) {
				return false;
			}
		} elseif ($_SESSION['n3k0t'] != hash_hmac('sha256', $_SESSION['s3ss10nCr3at3d'], $this->hashKey)) {
				return false;
        }

		// Is session expired ?
		if ((time() > ($_SESSION['s3ss10nCr3at3d'])+$this->expiration)) {
			return false;
		}

		// Everything is fine return true
		return true;
	}

    /**
     * Completely regenerate session.
     */
    public function regenerate()
    {
		// Clear old session data
		$_SESSION = [];
		// Set session start time
        $_SESSION['s3ss10nCr3at3d'] = time();
		// Set new session token
		if ($this->matchUserAgent) {
            $_SESSION['n3k0t'] = hash_hmac('sha256', $_SERVER['HTTP_USER_AGENT'].$_SESSION['s3ss10nCr3at3d'], $this->hashKey);
		} else {
            $_SESSION['n3k0t'] = hash_hmac('sha256', $_SESSION['s3ss10nCr3at3d'], $this->hashKey);
		}
        // Regenerate session
        session_regenerate_id();
    }

    /**
    * @param string
    * @return mixed
    */
    public function get($key)
    {
    	return $_SESSION[$key];
    }

    /**
    * @param string
    * @param mixed
    */
    public function set($key, $value)
    {
    	$_SESSION[$key] = $value;
    }

    /**
    * @return array
    */
    public function all()
    {
    	return $_SESSION;
    }

    /**
    * Clear session values.
    */
    public function flush()
    {
    	$_SESSION = [];
    }

    /**
    * @param string
    */
    public function forget($key)
    {
    	unset($_SESSION[$key]);
    }

    /**
    * @param string
    */
    public function has($key)
    {
    	return isset($_SESSION[$key]);
    }
}