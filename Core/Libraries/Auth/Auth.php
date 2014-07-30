<?php 
namespace Core\Libraries\Auth;

use \Core\Core\Core;

/**
* Authentication class.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Auth
{
	/**
	 * User table.
	 * @var string
	 */
	private $table = 'users';

	/**
	 * Connections variable to use work with database,
	 * loaded in class constructor.
	 * @var object \PDO
	 */
	private $conn = null;

	/**
	 * PasswordHash object, used for
	 * password hashing.
	 * @var object
	 */
	private $hasher = null;

	/**
	 * Class constructor.
	 * @param array
     * @param object \PDO
	 */
	public function __construct(array $params = [], \PDO $conn = null)
	{
		// Take parameters from passed array
        foreach ($params as $key => $val) {
            $this->$key = $val;
        }

		// Try to get database connection from core class if one is not passed.
		if ($conn === false) {
			$this->conn = $this->getDbConnection();
		} else {
			$this->conn = $conn;
		}
		
		// Create hasher tool
		$this->hasher = new PasswordHash(8, FALSE);
	}

	/**
	* Get PDO connection object.
	* @return object \PDO
	*/
	private function getDbConnection()
	{
		return Core::getInstance()['dbdefault']->getConnection();
	}

	/**
	 * Set table to work with.
	 * @var string 
	 */
	public function setTable($table)
	{
		$this->table = $table;
	}

	/**
	 * Create user.
	 * @var string
	 * @var string
	 * @return bool
	 */
	public function createUser($username, $password)
	{
		// Check if user exists
		$stmt = $this->conn->prepare("SELECT user_name FROM $this->table WHERE user_name = :name");
		$stmt->execute([':name'=>$username]);
		$result = $stmt->fetchAll();
		// If username exists return false
		if (count($result)) {
			return false;
		}
		// Hash password
		$password = $this->hasher->HashPassword($password);
		// Insert into database
		$stmt = $this->conn->prepare("INSERT INTO $this->table (user_name, user_pass, user_created_on) VALUES (:name, :pass, now())");
		$stmt->execute([':name'=>$username,':pass'=>$password]);
		// Return sucess status
		if ($stmt->rowCount()==1) {
			return true;
		}
		return false;
	}

	/**
	 * Change user password.
	 * @param  string
	 * @param  string
	 * @return bool
	 */
	public function changePassword($username, $newPass)
	{
        $stmt = $this->conn->prepare("UPDATE $this->table SET user_pass=:newPass WHERE user_name=:username");
        return $stmt->execute([':newPass'=>$newPass, ':username'=>$username]);
	}

	/**
	 * Delete user.
	 * @var string
	 * @return int
	 */
	public function deleteUser($username)
	{
        $stmt = $this->conn->prepare("DELETE * FROM $this->table WHERE user_name = :name");
        $stmt->execute([':name'=>$username]);
        return $stmt->rowCount();
	}

	/**
	 * Try to login user with passed parameters.
	 * @var string
	 * @var string
	 * @return bool 
	 */
	public function login($username, $password)
	{
		$stmt = $this->conn->prepare("SELECT user_id, user_name, user_pass 
			FROM $this->table WHERE user_name = :name LIMIT 1");
		$stmt->execute([':name'=>$username]);
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		if ($result['user_name']!=$username) {
			return false;
		}

		if ($this->hasher->CheckPassword($password, $result['user_pass'])) {
			// Clear previous session
            Core::getInstance()['session']->regenerate();
			// Write new data to session
            $_SESSION['user']['id'] = $result['user_id'];
			$_SESSION['user']['logged_'.$this->table] = true;
			return true;
		}
		return false;
	}

        /*
         * Create users table
         * @param string
         * @return bool
         */
	public function createTable($name)
	{
		$stmt = $this->conn->prepare("CREATE TABLE $name (
			  user_id int(10) unsigned NOT NULL auto_increment,
			  user_name varchar(255) NOT NULL default '',
			  user_pass varchar(60) NOT NULL default '',
			  user_date datetime NOT NULL default '0000-00-00 00:00:00',
			  user_modified datetime NOT NULL default '0000-00-00 00:00:00',
			  user_last_login datetime NULL default NULL,
			  PRIMARY KEY  (user_id),
			  UNIQUE KEY user_name (user_name)
			) DEFAULT CHARSET=utf8");
		return $stmt->execute();
	}

    /**
     * Get id of current logged user, return false if no user logged.
     * @return int|bool
     */
    public function getUserId()
    {
        if ($this->isLogged()) {
            return $_SESSION['user']['id'];
        } else {
            return false;
        }
    }
        
	/**
	 * Check if there is logged user,
	 * returns false or logged user id.
	 * @return boolean|int
	 */
	public function isLogged()
	{
        if (isset($_SESSION['user']['logged_'.$this->table])
            && $_SESSION['user']['logged_'.$this->table]===true) {
        	return true;
        }
        return false;
	}

	/**
	 * Logout current user.
	 */
	public function logout()
	{
		session_unset();
		session_destroy();
	}
}