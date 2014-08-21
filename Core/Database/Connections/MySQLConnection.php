<?php
namespace Core\Database\Connections;

/**
 * Class MySQLConnection.
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
    * @return object \PDO
    * @throws \PDOException
    * @throws \InvalidArgumentException
    */
    public function connect()
    {
        try {
            // Make string containing database settings
            $database = 'mysql:host='.$this->host.';dbname='.$this->database.';charset='.$this->charset;

            // Make connection.
            $conn = new \PDO($database, $this->username, $this->password);

            // Set attributes from parameters
            $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, $this->fetch);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, $this->error);

            return $conn;
        } catch (\PDOException $ex) {
            throw new \InvalidArgumentException('Error! Cannot connect to database '.$ex->getMessage());
        }
    }
}