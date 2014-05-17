<?php 
namespace Core\Core;

/**
* Error class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Error 
{
	/**
	 * Array containing error logs.
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
	* Write errors log to text file.
	*/
	public static function writeLog()
	{
		file_put_contents('Errors.txt', self::$log, FILE_APPEND | LOCK_EX);
	}

    /**
     * Display error page with message.
    */
	public static function displayLog()
	{
		foreach (self::$log as $value) {
			if($value[2]!==null) {
				$value[2] = ' <strong>Line:'.$value[2].'</strong>';
			}
			echo '<p><strong>'.$value[0].'</strong> '.$value[1].$value[2].'</p>';
		}
	}
}