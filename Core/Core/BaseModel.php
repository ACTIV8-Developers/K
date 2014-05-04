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
    * @return object
    */
    protected function db()
    {
        return Core::getInstance()['database'];
    }
}