<?php 
namespace Core\Database\Connections;

/**
* Database abstract PDO connection.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
abstract class PDOConnection
{

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
     * Connect to database and return PDO object connection variable
     *
     * @return object \PDO
     */
    abstract public function connect();
}