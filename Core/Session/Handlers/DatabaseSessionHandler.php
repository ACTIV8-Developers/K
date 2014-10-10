<?php
namespace Core\Session\Handlers;

/**
* Session handler using database interface.
    CREATE TABLE `session_handler_table` (
    `id` varchar(255) NOT NULL,
    `data` mediumtext NOT NULL,
    `timestamp` int(255) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
class DatabaseSessionHandler implements \SessionHandlerInterface
{
	
	/**
	* PDO connection.
	* @var \PDO
	*/
	protected $dbConnection = null;

    /**
     * Table name if storage system is database
     *
     * @var string
     */
    protected $tableName = 'sessions';

    /**
    * @param object \PDO
    */
    public function __construct(\PDO $db) 
    {
        $this->db = $db;
    }

	/**
	* Inject DB connection from outside
	*
	* @param object \PDO
	*/
	public function setDbConnection($dbConnection)
	{
		$this->dbConnection = $dbConnection;
	}

	/**
	* Inject DB connection from outside
	* @param string
	*/
	public function setDbTable($tableName)
	{
		$this->tableName = $tableName;
	}

	/**
	* Open the session
	*
	* @return bool
	*/
	public function open() 
	{
		//delete old session handlers
		$limit = time() - (3600 * 24);
		$sql = sprintf("DELETE FROM %s WHERE timestamp < %s", $this->tableName, $limit);
		return $this->dbConnection->query($sql);
	}

	/**
	* Close the session
	* @return bool
	*/
	public function close() 
	{
		return $this->dbConnection->close();
	}

	/**
	* Read the session
	*
	* @param int session id
	* @return string string of the sessoin
	*/
	public function read($id) 
	{
		$sql = sprintf("SELECT data FROM %s WHERE id = '%s'", $this->tableName, $this->dbConnection->escape_string($id));
		if ($result = $this->dbConnection->query($sql)) {
			if ($result->num_rows && $result->num_rows > 0) {
				$record = $result->fetch_assoc();
				return $record['data'];
			} else {
				return false;
			}
		} else {
			return false;
		}
		return true;
	}

	/**
	* Write the session
	*
	* @param int session id
	* @param string data of the session
	*/
	public function write($id, $data) 
	{
		$sql = sprintf("REPLACE INTO %s VALUES('%s', '%s', '%s')",
		$this->tableName,
		$this->dbConnection->escape_string($id),
		$this->dbConnection->escape_string($data),
		time());
		return $this->dbConnection->query($sql);
	}

	/**
	* Destoroy the session
	*
	* @param int session id
	* @return bool
	*/
	public function destroy($id) 
	{
		$sql = sprintf("DELETE FROM %s WHERE `id` = '%s'", $this->tableName, $this->dbConnection->escape_string($id));
		return $this->dbConnection->query($sql);
	}

	/**
	* Garbage Collector
	*
	* @param int life time (sec.)
	* @return bool
	* @see session.gc_divisor 100
	* @see session.gc_maxlifetime 1440
	* @see session.gc_probability 1
	* @usage execution rate 1/100
	* (session.gc_probability/session.gc_divisor)
	*/
	public function gc($max) 
	{
		$sql = sprintf("DELETE FROM %s WHERE `timestamp` < '%s'", $this->tableName, time() - intval($max));
		return $this->dbConnection->query($sql);
	}
}