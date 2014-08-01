<?php 
namespace Core\Core;

/**
* Base model class.
* Used with alias "Model".
* 
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class BaseModel
{
    /**
    * Get database object.
    * @param string
    * @return object \PDO
    */
    protected function db($dbName = 'default')
    {
        return Core::getInstance()['db'.$dbName ];
    }

    /**
	* Load library.
    * @param string
    * @param array
    * @return object
    */
    protected function library($library, array $params = [])
    {
    	$library = '\\Core\\Libraries\\'.$library.'\\'.$library;
		return new $library($params);
    }
}