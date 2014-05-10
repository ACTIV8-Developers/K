<?php 
namespace Core\Database;

/**
* Database connection class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Connection
{
	/**
	* @var resource
	*/
	protected $connection = null;

	/**
	* @var \PDO::ATTR_DEFAULT_FETCH_MODE
	*/
	protected $fetchMode = null;

	/**
	 * Class constructor.
	 * Connect to database with passed settings.
	 * @throws PDOException
	 * @param array
	 */
    public function __construct($params)
    {
		// Select database type (mysql, pgsql or sqlsrv)
		switch($params['type']) {
			case 'mysql': $database = 'mysql:host='.$params['host'].';dbname='.$params['database'].
									';charset='.$params['mysql']['charset'];
			break;
			case 'pgsql':
			// TO DO 
			break;
			case 'sqlsrv':
			// TO DO
			break;
		}
    	// Make connection.
	    $this->connection = new \PDO($database, $params['username'], $params['password']);
	    // Set attributes from parameters
	    $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, $params['fetch']);
    	$this->connection->setAttribute(\PDO::ATTR_ERRMODE, $params['error']);
    }

	/**
	* Classic query method using prepared statements.
	* @param string (query to execute)
	* @param array (parameter array)
	* @return resource (query result)
	*/
	public function query($query, $params = null)
	{
		// Execute query
		$stmt = $this->connection->prepare($query);
		if($params) {
			$stmt->execute($params);
		} else {
			$stmt->execute();
		}
		// Return result resource variable
		return $stmt;
	}

    /**
    * Get connection variable.
    * @return resource
    */
    public function getConnection()
    {
    	return $this->connection;
    }

    /**
    * Set PDO fetch mode
    * @param \PDO::ATTR_DEFAULT_FETCH_MODE
    */
    public function setFetchMode($fetchMode)
    {
    	$this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, $fetchMode);
    }
}