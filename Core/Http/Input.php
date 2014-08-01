<?php 
namespace Core\Http;

use \Core\Util\Security;

/**
* Input class.
* This class is used for fetching request input data from 
* common sources such as POST, PUT, DELETE etc.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Input
{
	/**
	* Get an item or array from input data.
	* @param string
	* @param bool
	* @return array|mixed|null
	*/
	public function get($index, $xssClean = false)
	{
		// Detect method.
		$method = strtolower($_SERVER['REQUEST_METHOD']);

		return $this->$method($index, $xssClean);
	}

	/**
	* Get an item or array from POST data.
	* @param string
	* @param bool
	* @return array|mixed|null
	*/
	public function post($index = null, $xssClean = false)
	{
		return $this->getData($_POST, $index, $xssClean);
	}

    /**
	* Get an item or array from PUT data.
	* @param string
    * @param bool
	* @return array|mixed|null
	*/
    public function put($index = null, $xssClean = false)
    {
        $_PUT = [];  
	    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {  
	        parse_str(file_get_contents('php://input'), $_PUT);  
	    }  
	    return $this->getData($_PUT, $index, $xssClean);
    }

    /**
	* Get an item or array from PATCH data.
	* @param string
    * @param bool
	* @return array|mixed|null
	*/
    public function patch($index = null, $xssClean = false)
    {
        $_PATCH = [];  
	    if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {  
	        parse_str(file_get_contents('php://input'), $_PATCH);  
	    }  
	    return $this->getData($_PATCH, $index, $xssClean);
    }

    /**
	* Get an item or array from DELETE data.
	* @param array
	* @param bool
	* @return array|mixed|null
	*/
    public function delete($index = null, $xssClean = false)
    {      
        $_DELETE = [];  
	    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {  
	        parse_str(file_get_contents('php://input'), $_DELETE);  
	    }  
	    return $this->getData($_DELETE, $index, $xssClean);
    }

    /**
	* This is a helper function to retrieve values from global arrays.
	* @param array
	* @param string
	* @param bool
	* @return string
    */
    private function getData(&$data, $index = '', $xssClean = false)
    {
		// Check if a field has been provided
		if ($index === NULL && !empty($data)) {
			$array = [];
			foreach (array_keys($data) as $key) {
				$array[$key] = $this->getParam($data, $key, $xssClean);
			}
			return $array;
		}
		return $this->getParam($data, $index, $xssClean);
    }

	/**
	 * This is a helper function to retrieve value from array.
	 * @param array
	 * @param string
	 * @param bool
	 * @return string|bool
	 */
	private function getParam(&$array, $index = '', $xssClean = false)
	{
		if (!isset($array[$index])) {
			return false;
		}

		if (true === $xssClean) {
			return Security::xssClean($array[$index]);
		}
		return $array[$index];
	}
}