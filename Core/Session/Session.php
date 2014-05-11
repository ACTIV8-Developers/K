<?php 
namespace Core\Session;

/**
* Session manager class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Session
{
    /**
     * Encryption key
     * @var string
     */
    const SUPER_KEY = 'wer23wasf23';

	/**
	* Lifetime of the session cookie and session duration, defined in seconds.
	* @var int
	*/
	private $expiration = 7200;

	/**
	* Used to restrict where the browser sends the cookie (Use a single slash ('/') for all paths on the domain. )
	* @var string
	*/
	private $path = '/';

	/**
	* Cookie domain, for example 'www.php.net'. 
	* To make cookies visible on all subdomains then the domain must be prefixed with a dot like '.php.net'. 
	* @var string|null
	*/
	private $domain = "";

	/**
	* If true the browser only sends the cookie over https.
	* Null denotes class will decide.
	* @var bool|null
	*/
	private $secure = null;

	/**
	* Marks the cookie as accessible only through the HTTP protocol. 
	* This means that the cookie won't be accessible by scripting languages, such as JavaScript. 
	* @var bool
	*/
	private $httponly = true;

	/**
	* Session name
	* @var string
	*/
	private $name = 'dAlkW';

	/**
	* Session storage system
	* @var string
	*/
	private $handler = 'file';

	/**
	* Match user agent across session requests
	* @var bool
	*/
	private $matchUseragent = true;

	/**
	* Table name if storage system is database
	* @var string
	*/
	private $tableName = 'sessions';

	/**
	* Period of refreshing session ID
	* @var int
	*/
	private $updateChance = 30;

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
        // Hash algorithm to use for the session_id. (use hash_algos() to get a list of available hashes.)
        $session_hash = 'sha256';

        // Check if hash is available
        if (in_array($session_hash, hash_algos())) {
            // Set the has function.
            ini_set('session.hash_function', $session_hash);
        }

		// Set session cookie name
		session_name($this->name.'z1c4z');

      	// Set the default secure value to whether the site is being accessed with SSL
      	$this->secure = $this->secure!==null ? $this->secure : isset($_SERVER['HTTPS']);

      	// Set the domain to default or to the current domain.
      	$this->domain = isset($this->domain) ? $this->domain : isset($_SERVER['SERVER_NAME']);

	    // Set the cookie settings
      	session_set_cookie_params($this->expiration, $this->path, $this->domain, $this->secure, $this->httponly);

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
            $_SESSION['s3ss10nCr3at3d'] = time();
			// Set new session token
			if($this->matchUseragent) {
				$_SESSION['n3k0t'] = hash_hmac('sha256', $_SERVER['HTTP_USER_AGENT'].$_SESSION['s3ss10nCr3at3d'], self::SUPER_KEY);
			} else {
				$_SESSION['n3k0t'] = hash_hmac('sha256', $_SESSION['s3ss10nCr3at3d'], self::SUPER_KEY);
			}
		}

		// Regenerate session ID cycle
		if(mt_rand(1, 100)<$this->updateChance) {
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
		// Are needed session variables set ?
		if(empty($_SESSION['s3ss10nCr3at3d']) || empty($_SESSION['n3k0t'])) {
			return false;
		}

		// Check if session token match ?
		if($this->matchUseragent) {
			if($_SESSION['n3k0t']!=hash_hmac('sha256', $_SERVER['HTTP_USER_AGENT'].$_SESSION['s3ss10nCr3at3d'], self::SUPER_KEY)) {
				return false;
			}
		} else {
			if($_SESSION['n3k0t']!=hash_hmac('sha256', $_SESSION['s3ss10nCr3at3d'], self::SUPER_KEY)) {
				return false;
			}
		}

		// Is session expired ?
		if((strtotime("now") - $_SESSION['s3ss10nCr3at3d'])>$this->expiration) {
			return false;
		}

		// Everything is fine return true
		return true;
	}

    /**
     * Completely regenerate session.
     * Usualy called on logins or security level changes.
     */
    public function regenerate()
    {
		// Clear old session data
		$_SESSION = [];
		// Set session start time
        $_SESSION['s3ss10nCr3at3d'] = time();
		// Set new session token
		if($this->matchUseragent) {
			$_SESSION['n3k0t'] = $_SERVER['HTTP_USER_AGENT'].$_SESSION['s3ss10nCr3at3d'];
		} else {
			$_SESSION['n3k0t'] = $_SESSION['s3ss10nCr3at3d'];
		}
        // Regenerate session
        session_regenerate_id(true);
    }
}