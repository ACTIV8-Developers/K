<?php
namespace Core\Modules; 

/**
* Setup class install all dependecies for enabled modules.
* It should be called as described in App\Config\routes.php
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Setup extends \Core\Core\BaseController
{
	/**
	* Class constructor calls all setup classes
	* for enabled modules.
	* @throws InvalidArgumentException
	*/
	public function __construct()
	{
		foreach($this->modulesList() as $module => $value) {
			if ($value) {
                $class = '\\Core\Modules\\'.$module.'\\Setup';
                if(class_exists($class)) {
                	new $class();
                } else {
					throw new \InvalidArgumentException('Application configuration error!');
                }
			}
		}
	}
}