<?php
namespace Core\ActiveRecord;

/**
* Active record class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class ActiveRecord extends Connection
{
	/**
	* @var string
	*/
	private $select = '*';

	/**
	* @var string
	*/
	private $where = null;

	/**
	* Set select condition
	* @param string
	*/
	public function select($select)
	{
		$this->select = $select;
	}

	/**
	* Set where condition
	* @param string
	*/
	public function where($where)
	{
		$this->where = $where;
	}

	/**
	* Select query.
	* @param string
	* @param string
	* @return array
	*/
	public function get($table, $limit = null)
	{
		// Build basic query
		$query = 'SELECT '.$this->select.' FROM '.$table;

		// Add where condition if passed
		if($this->where) {
			$where = '';
			foreach ($this->where as $key => $value) {
				$where .= ','.$key.'=:'.$key;	
			}
			$query .= ' '.substr($where, 1);
		}

		// Add limit if needed
		if($this->limit) {
			$query .= ' '.$limit;	
		}

		// Prepare query
	  	$stmt = $this->connection->prepare($query);
	  	
	  	// Execute query
	  	if($this->where) {
	  		$stmt->execute($this->where);
	  	} else {
	  		$stmt->execute();
	  	}
	  	return $stmt->fetchAll();
	}

	/**
	* Update query
	* @param string
	* @param array
	* @return int
	*/
	public function insert($table, $data)
	{
		$names = '';
		$values = '';
		foreach ($data as $key => $value) {
			$names .= ','.$key;
			$values .= ',:'.$key;
		}
		$query = 'INSERT INTO '.$table.'('.substr($names, 1).') VALUES ('.substr($values, 1).')'
	  	$stmt = $this->connection->prepare($query);
	  	$stmt->execute($data);
	  	return $stmt->rowCount();
	}
}