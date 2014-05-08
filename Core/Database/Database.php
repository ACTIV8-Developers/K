<?php 
namespace Core\Database;

/**
* Basic database class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Database extends Connection 
{
	/**
	* Class constructor.
	*/
    public function __construct($params) 
    {
    	parent::__construct($params);
    }

	/**
	* Select query.
	* @param string (query to execute)
	* @param array (parameter array)
	* @param string (return type)
	* @return associative array (query result)
	*/
	public function select($query, $params = [], $fetch = null)
	{
	  	// execute query	
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	if($fetch!=null) 
			$stmt->setFetchMode($fetch);
	  	return $stmt->fetchAll();
	}

	/**
	* Insert query.
	* @param string (query to execute)
	* @param array (parameter array)
	* @return int (number of affected rows)
	*/
	public function insert($query, $params)
	{
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	return $stmt->rowCount();
	}

	/**
	* Update query.
	* @param string (query to execute)
	* @param array (parameter array)
	* @return int (number of affected rows)
	*/
	public function update($query, $params)
	{
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	return $stmt->rowCount();
	}

	/**
	* Delete query.
	* @param string (query to execute)
	* @param array (parameter array)
	* @return int (number of affected rows)
	*/
	public function delete($query, $params)
	{
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($params);
	  	return $stmt->rowCount();
	}

	/**
	* Count query.
	* @param string (query to execute)
	* @param array (parameter array)
	* @return int (number of rows)
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
    	if($options==null)
    		$sql .= ") CHARACTER SET utf8 COLLATE utf8_general_ci";
		else
			$sql .= $options;

		// execute query	
	  	$stmt = $this->connection->prepare($sql);
	  	return $stmt->execute();
	}
}