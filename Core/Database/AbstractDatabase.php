<?php
namespace Core\Database;

/**
* AbstractDatabase class.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
abstract class AbstractDatabase
{
    /**
     * Database connection.
     *
     * @var object \PDO
     */
    protected $connection = null;

    /**
     * Set connection variable.
     *
     * @var object \PDO
     */
    public function setConnection(\PDO $conn)
    {
        $this->connection = $conn;
    }

    /**
     * Get connection variable.
     *
     * @return object \PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
    * Sets PDO attribute.
    *
    * @param int
    * @param mixed (attribute value)
    * @return bool
    */
    public function setAttribute($attr, $value)
    {
    	$this->connection->setAttribute($attr, $value);
    }
}