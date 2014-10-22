<?php 
namespace Core\Core;

/**
* Base model abstract class.
* 
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
abstract class Model
{
    /**
    * Get database object.
    *
    * @param string
    * @return object \Core\Database\Database
    */
    protected function db($dbName)
    {
        return Core::getInstance()['db.'.$dbName ];
    }
}