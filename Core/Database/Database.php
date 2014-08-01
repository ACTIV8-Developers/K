<?php 
namespace Core\Database;

use \Core\Database\Connections\PDOConnection as PDOConn;

/**
* Basic database class used for common CRUD operations.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Database
{
    /**
     * Database connection.
     * @var object \PDO
     */
    protected $connection = null;

	/**
	* Class constructor.
    * @var object \PDOConn
	*/
    public function __construct(PDOConn $PDOConn)
    {
        $this->connection = $PDOConn->getConnection();
    }

    /**
     * Set connection variable.
     * @var object \PDO
     */
    public function setConnection(PDOConn $PDOConn)
    {
        $this->connection = $PDOConn;
    }

    /**
     * Get connection variable.
     * @return object \PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
    * Sets PDO attribute.
    * @param int
    * @param mixed (attribute value)
    * @return bool
    */
    public function setAttribute($attr, $value)
    {
    	$this->connection->setAttribute($attr, $value);
    }

    /**
    * Begin database transaction.
    */
    public function beginTrans()
    {
    	$this->connection->beginTransaction();
    }

    /*
    * Commit database construction.
    */
    public function commit()
    {
    	$this->connection->commit();
    }

    /**
    * Rollback current database transaction.
    */
    public function rollback()
    {
    	$this->connection->rollBack();	
    }

    /**
     * Classic query method using prepared statements.
     * @param string
     * @param array
     * @return resource
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
	* Select query.
	* @param string
	* @param array
	* @param string
	* @return array
	*/
	public function select($query, $params = [], $fetch = null)
	{
	  	// execute query	
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	if($fetch!=null) {
			$stmt->setFetchMode($fetch);
	  	}
	  	return $stmt->fetchAll();
	}

	/**
	* Insert query.
	* @param string
	* @param array
	* @return int
	*/
	public function insert($query, $params)
	{
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	return $stmt->rowCount();
	}

	/**
	* Wrapper for PDO last insert id.
	* @param string
	* @return int
	*/
	public function lastInsertId($name = null)
	{
	  	return $this->connection->lastInsertId($name);
	}

	/**
	* Update query.
	* @param string
	* @param array
	* @return int
	*/
	public function update($query, $params)
	{
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	return $stmt->rowCount();
	}

	/**
	* Delete query.
	* @param string
	* @param array
	* @return int
	*/
	public function delete($query, $params)
	{
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	return $stmt->rowCount();
	}

	/**
	* Count query.
	* @param string
	* @param array
	* @return int
	*/
	public function count($query, $params)
	{
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	return $stmt->fetchColumn();
	}

	/**
	* Create table in database.
	* @param $name (table name)
	* @param $fields (fields array to insert)
	* @param $options (additional options for table like engine, UTF etc)
	* Fields array example ['id'=>'INT AUTO_INCREMENT PRIMARY KEY NOT NULL',
	*						'value'=>'varchar(10)']
    * @return int
	*/
	public function createTable($name, $fields, $options = null)
	{
		// Make query
		$sql = "CREATE TABLE IF NOT EXISTS $name (";
	    foreach($fields as $field => $type) {
      		$sql.= "$field $type, ";
      		if (preg_match('/AUTO_INCREMENT/i', $type)) {
        		$pk = $field;
      		}
    	}
    	$sql = rtrim($sql,',') . ' PRIMARY KEY ('.$pk.')';
    	if($options==null) {
    		$sql .= ") CHARACTER SET utf8 COLLATE utf8_general_ci";
        } else {
			$sql .= $options;
        }

		// execute query	
	  	$stmt = $this->connection->prepare($sql);
	  	return $stmt->execute();
	}
}