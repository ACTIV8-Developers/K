<?php 
namespace Core\Core;

/**
* Base model class.
* Used with alias "Model".
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class BaseModel
{
    /**
    * Get database object.
    * @param string
    * @return object
    */
    protected function db($dbName = 'default')
    {
        return Core::getInstance()['db'.$dbName ];
    }
}