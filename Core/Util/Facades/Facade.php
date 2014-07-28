<?php
namespace Core\Util\Facades;

use Core\Core\Core;

/**
* Facade class
* @author miloskajnaco@gmail.com
*/
abstract class Facade 
{

    protected static function getName()
    {
        throw new Exception('Facade does not implement getName method.');
    }

    public static function __callStatic($method, $args)
    {
        $instance = Core::getInstance()[static::getName()];

        if (!method_exists($instance, $method)) {
            throw new Exception(get_called_class() . ' does not implement ' . $method . ' method.');
        }

        return call_user_func_array([$instance, $method], $args);
    }

}