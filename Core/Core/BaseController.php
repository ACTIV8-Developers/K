<?php 
namespace Core\Core;

/**
* Base controller class.
* Used with alias "Controller".
* Extend to get access to app main container.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class BaseController
{
    /**
	* Load library.
    * @param string
    * @param array
    * @return object
    */
    protected function library($library, $params = [])
    {
    	$library = '\\Core\\Libraries\\'.$library.'\\'.$library;
		return new $library($params);
    }

    /**
    * Load model.
    * @param string
    * @return object
    */
    protected function model($model)
    {
        require APP.'Models/'.$model.'.php';
        $model = explode('/', $model);
        $model = end($model);
        return new $model();
    }

    /**
    * Get request object.
    * @return object
    */
    protected function request()
    {
        return Core::getInstance()['request'];
    }

    /**
    * Get input object.
    * @return object
    */
    protected function input()
    {
        return Core::getInstance()['input'];
    }

    /**
    * Get response object.
    * @return object
    */
    protected function response()
    {
        return Core::getInstance()['response'];
    }

    /**
    * Get configuration.
    * @return array
    */
    protected function config()
    {
        return Core::getInstance()['config'];
    }

    /**
    * Load language file with defined constants
    * @param string
    */
    protected function language($lang)
    {
        include APP.'Languages/'.$lang.'.php';
    }

    /**
    * Get any object from app main container.
    * @param string
    * @return object|mixed
    */
    protected function get($name)
    {
        return Core::getInstance()[$name];
    }

    /**
    * Put anything into main container.
    * @param string
    * @param object|mixed
    */
    protected function put($name, $object)
    {
        Core::getInstance()[$name] = $object; 
    }

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