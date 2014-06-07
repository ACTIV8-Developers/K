<?php 
namespace Core\Database\Connections;

/**
* Database abstract PDO connection.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
abstract class PDOConnection
{
    /**
     * Database connection.
     * @var resource
     */
    protected $connection = null;

    /**
     * @var \PDO::ATTR_DEFAULT_FETCH_MODE
     */
    protected $fetch = \PDO::FETCH_ASSOC;

    /**
     * @var \PDO::ERRMODE
     */
    protected $error = \PDO::ERRMODE_EXCEPTION;

    /**
     * @var string
     */
    protected $host = 'localhost';

    /**
     * @var string
     */
    protected $database = 'k_db';

    /**
     * @var string
     */
    protected $username = 'root';

    /**
     * @var string
     */
    protected $password = '';

    /**
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * @var string
     */
    protected $collation = 'utf8_unicode_ci';

    /**
     * Connect to database and store resource in connection variable
     */
    abstract protected function connect();

    /**
     * Get connection variable.
     * @return resource
     */
    public function getConnection()
    {
        if(null==$this->connection) {
            $this->connect();
        }
        return $this->connection;
    }
}