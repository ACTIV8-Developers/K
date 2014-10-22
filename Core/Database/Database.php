<?php 
namespace Core\Database;

/**
* Basic database class used for common CRUD operations.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Database extends AbstractDatabase
{
    /**
    * Begin database transaction.
    */
    public function beginTransaction()
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
     *
     * @param string
     * @param array
     * @return resource
     */
    public function query($query, $params = null)
    {
        // Execute query
        $stmt = $this->connection->prepare($query);
        if ($params) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }
        // Return result resource variable
        return $stmt;
    }

	/**
	* Select query.
	*
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
	  	if ($fetch !== null) {
			$stmt->setFetchMode($fetch);
	  	}
	  	return $stmt->fetchAll();
	}

	/**
	* Insert query.
	*
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
	*
	* @param string
	* @return int
	*/
	public function lastInsertId($name = null)
	{
	  	return $this->connection->lastInsertId($name);
	}

	/**
	* Update query.
	*
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
	*
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
	*
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
	* Create table in database(MySQL specific).
	*
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
	    foreach ($fields as $field => $type) {
      		if (preg_match('/PRIMARY KEY/i', $type)) {
        		$pk = $field;
        		$type = str_replace('PRIMARY KEY', '', $type);
      		}
      		$sql .= "$field $type, ";
    	}
    	if (isset($pk)) {
    		$sql = rtrim($sql, ",").' PRIMARY KEY ('.$pk.')';
    	} else {
    		$sql = substr($sql, 0, strlen($sql) - 2);
    	}
    	if ($options === null) {
    		$sql .= ") CHARACTER SET utf8 COLLATE utf8_general_ci;";
        } else {
			$sql .= ")".$options;
        }

		// execute query
	  	$stmt = $this->connection->prepare($sql);
	  	return $stmt->execute();
	}
}