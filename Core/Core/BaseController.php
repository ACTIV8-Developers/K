<?php
namespace Core\Core;

/**
* Base controller class.
* Used with alias "Controller".
* Extend to get access to app main container.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class BaseController
{
    /**
	* Load library.
    * @param string
    * @param array
    * @return object|null
    */
    protected function library($library, array $params = [])
    {
    	$library = '\\Core\\Libraries\\'.$library.'\\'.$library;
        if (class_exists($library)) {
            return new $library($params);
        }
        return null;	
    }

    /**
    * Load model.
    * @param string
    * @return object
    */
    protected function model($model)
    {
        $model = MODELS."\\".$model;
        return new $model();
    }

    /**
    * Get request object.
    * @return object \Core\Http\Request
    */
    protected function request()
    {
        return Core::getInstance()['request'];
    }

    /**
    * Get input object.
    * @return object \Core\Http\Input
    */
    protected function input()
    {
        return Core::getInstance()['input'];
    }

    /**
    * Get response object.
    * @return object \Core\Http\Response
    */
    protected function response()
    {
        return Core::getInstance()['response'];
    }

    /**
    * Get response object.
    * @return object \Core\Http\Cookies
    */
    protected function cookies()
    {
        return Core::getInstance()['cookies'];
    }

    /**
    * Get session object.
    * @return object \Core\Session\Session
    */
    protected function session()
    {
        return Core::getInstance()['session'];
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
    * Load language file with defined constants.
    * @param string
    */
    protected function language($lang)
    {
        include APP.'Languages/'.$lang.'.php';
    }

    /**
    * Get database object.
    * @param string
    * @return object \Core\Database\Database
    */
    protected function db($dbName = 'default')
    {
        return Core::getInstance()['db'.$dbName ];
    }
}