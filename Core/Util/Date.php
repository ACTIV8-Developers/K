<?php 
namespace Core\Util;

/**
* Date utility class.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Datte
{
	/**
	 * Converts from ISO 8601 (yy-mm-dd) to dd-mm-yy format and vice-versa.
	 *
	 * @param  string
	 * @param char
	 * @return string
	 */
	public static function convertDate($date, $delimiter = '-')
	{
		$date = explode($delimiter, $date);
		return $date[2].'-'.$date[1].'-'.$date[0];
	}

	/**
	 * Converts from ISO 8601 (yy-mm-dd) to serbian display date.
	 *
	 * @param  string
	 * @param char
	 * @return string
	 */
	public static function convertSrbDate($date, $delimiter = '-')
	{
		$date = explode($delimiter, $date);
		return $date[2].'.'.$date[1].'.'.$date[0].'.';
	}
}