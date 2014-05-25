<?php 
namespace Core\Util;

/**
* Log class.
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
     * @param string
     * @param string
     */
    public static function log($message, $type, $line)
	{
		self::$log[] = [$message, $type, $line];
	}

	/**
	* Write log to text file.
	* @param bool
	*/
	public static function writeLog($clear)
	{
		file_put_contents('Log.txt', self::$log, FILE_APPEND | LOCK_EX);
		if($clear) {
			self::$log = [];
		}
	}
}