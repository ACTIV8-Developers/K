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
	* @var string|array
	*/
	private $where = '';

	/**
	* @var array
	*/
	private $data = null;

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
	* @param array
	*/
	public function where($where)
	{
		if(is_array($where)) {
			$this->data = $where;
			foreach ($where as $key => $value) {
					$this->where .= ','.$key.'=:'.$key;	
				}
		}
	}

	public function like($member, $param, $type = 'both')
	{
		if($type==='before') {
			$this->where .= 
		} elseif($type==='after') {
			$this->where .= ','.$key.'=:'.$key;	
		} else {

		}
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

		// Add where condition
		$query .= ' '.substr($this->where, 1);;

		// Add limit if needed
		if($this->limit) {
			$query .= ' '.$limit;	
		}

		// Prepare query
	  	$stmt = $this->connection->prepare($query);
	  	
	  	// Execute query
	  	if($this->data) {
	  		$stmt->execute($this->data);
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