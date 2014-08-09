<?php 
namespace Core\Util;

/**
* Log class.
* (To use log need to make directory writable)
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Log
{
	/**
	 * Array containing logs.
	 * @var array
	 */
	private static $log = [];

    /**
     * Add message to log.
     * @param string
     */
    public static function log($message)
	{
		self::$log[] = $message;
	}

	/**
	* Write log to text file.
	* @param bool
	*/
	public static function write($path = 'log.txt', $clear = false)
	{
		file_put_contents($path, self::$log, FILE_APPEND | LOCK_EX);
		if ($clear) {
			self::$log = [];
		}
	}
}