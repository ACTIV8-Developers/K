<?php
namespace Core\Database\Connections;

/**
 * Class MySQLConnection
 * @author Milos Kajnaco <miloskajnaco@gmail.com>
 */
class MySQLConnection extends PDOConnection
{
    /**
    * Class constructor.
    * @param array
    */
    public function __construct(array $params)
    {
        // Load configuration parameters
        foreach ($params as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }
    }

    /**
    * Connect to database with passed settings.
    * @throws \PDOException
    * @throws \InvalidArgumentException
    */
    protected function connect()
    {
        try {
            // Make string containing database settings
            $database = 'mysql:host='.$this->host.';dbname='.$this->database.';charset='.$this->charset;
            // Make connection.
            $this->connection = new \PDO($database, $this->username, $this->password);
            // Set attributes from parameters
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, $this->fetch);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, $this->error);
        } catch (\PDOException $ex) {
            throw new \InvalidArgumentException('Error! Cannot connect, invalid database settings.');
        }
    }
}