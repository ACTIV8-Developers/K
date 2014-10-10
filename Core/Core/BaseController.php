<?php
namespace Core\Core;

use Core\Core\Core as Core;

/**
* Base controller abstract class.
* Used with alias "Controller".
* Extend to get access to app main container and common functions.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class BaseController
{
    /**
    * Set value in container.
    *
    * @param string
    * @param mixed
    */
    protected function set($key, $value)
    {
        Core::getInstance()[$key] = $value;
    }

    /**
    * Get value from container.
    *
    * @param string
    * @return mixed
    */
    protected function get($key)
    {
        return Core::getInstance()[$key];
    }

    /**
    * Buffer output for display or return it as string.
    *
    * @param string
    * @param array
    * @param bool
    * @return string|null
    */
    protected function render($view, $data = [], $display = true)
    {
        // Extract variables.
        extract($data);

        // Start buffering.
        ob_start();

        // Load view file (root location is declared in APPVIEW constant).
        include APPVIEW.$view.'.php';

        // Append to output body or return string.
        if (true === $display) {
            Core::getInstance()['response']->writeBody(ob_get_contents());
            ob_end_clean();
        } else {          
            $buffer = ob_get_contents();
            ob_end_clean();
            return $buffer;
        }
    }

    /**
    * Display page with not found code.
    *
    * @param string
    */
    protected function NotFound($message = 'Not Found', $view = null)
    {
        Core::getInstance()['response']->setStatusCode(404);
        if ($view === null) {
            Core::getInstance()['response']->setBody($message);
        } else {
            ob_start();
            include APPVIEW.$view.'.php';
            Core::getInstance()['response']->setBody(ob_get_contents());
            ob_end_clean();
        }
    }

    /**
	* Load library.
    *
    * @deprecated As of 1.3 use get/set in Container and Dependecy injection.
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
    *
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
    *
    * @return object \Core\Http\Request
    */
    protected function request()
    {
        return Core::getInstance()['request'];
    }

    /**
    * Get response object.
    *
    * @return object \Core\Http\Response
    */
    protected function response()
    {
        return Core::getInstance()['response'];
    }

    /**
    * Get session object.
    *
    * @return object \Core\Session\Session
    */
    protected function session()
    {
        return Core::getInstance()['session'];
    }

    /**
    * Get configuration.
    *
    * @return array
    */
    protected function config()
    {
        return Core::getInstance()['config'];
    }

    /**
    * Load language file with defined constants.
    *
    * @param string
    */
    protected function language($lang)
    {
        include APP.'Languages/'.$lang.'.php';
    }

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
    * Redirect helper function.
    *
    * @var string
    * @var int 
    */
    protected function redirect($url = '', $statusCode = 303)
    {
        header('Location: '.\Core\Util\Util::base($url), true, $statusCode);
        die();
    }

    /**
    * Redirect helper function.
    *
    * @var string
    * @var int 
    */
    protected function redirectToUrl($url = '', $statusCode = 303)
    {
        header('Location: '.$url, true, $statusCode);
        die();
    }
}