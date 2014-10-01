<?php 
namespace Core\Core;

/**
* Base model abstract class.
* Used with alias "Model".
* 
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
abstract class BaseModel
{
    /**
    * Get database object.
    *
    * @param string
    * @return object \Core\Database\Database
    */
    protected function db($dbName = 'default')
    {
        return Core::getInstance()['db'.$dbName ];
    }

    /**
	* Load library.
    *
    * @param string
    * @param array
    * @return object
    */
    protected function library($library, array $params = [])
    {
        $library = '\\Core\\Libraries\\'.$library.'\\'.$library;
        if (class_exists($library)) {
            return new $library($params);
        }
        return null;
    }
}