<?php 
namespace Core\Util;

/**
* Utility class.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Util
{
	/**
	* Variable for caching baseUrl() call, since often it is called multitple times.
	* @var string
	*/
	private static $base = null;

	/**
	 * Get site base url.
	 * @param  string
	 * @return string
	 */
	public static function baseUrl($path = '')
	{
		// Check for checked version of base path
		if(null!==self::$base) {
			return self::$base.$path;
		}

		if (isset($_SERVER['HTTP_HOST'])) {
			$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
			$base_url .= '://'. $_SERVER['HTTP_HOST'];
			$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
			self::$base = $base_url;
			return $base_url.$path;
		}
	}

	/**
	 * Get CSS file path.
	 * @param  string
	 * @return string
	 */
	public static function css($css)
	{
		return self::baseUrl().'public/css/'.$css;
	}	

	/**
	 * Get JavaScript file path.
	 * @param  string
	 * @return string
	 */
	public static function js($js)
	{
		return self::baseUrl().'public/js/'.$js;
	}

	/**
	 * Get image file path.
	 * @param  string
	 * @return string
	 */
	public static function img($img)
	{
		return self::baseUrl().'public/images/'.$img;
	}

	/**
	 * Converts from ISO 8601 (yy-mm-dd) to dd-mm-yy format and vice-versa
	 * @param  string
	 * @return string
	 */
	public static function convertDate($date)
	{
		$date = explode('-',$date);
		return $date[2].'-'.$date[1].'-'.$date[0];
	}

	/**
	 * Converts from ISO 8601 (yy-mm-dd) to serbian display date
	 * @param  string
	 * @return string
	 */
	public static function convertSrbDate($date)
	{
		$date = explode('-',$date);
		return $date[2].'.'.$date[1].'.'.$date[0].'.';
	}

	/**
	* Extract language from given URI and put it into global variable,
	* return rest.
	* @param array
	* @param string
	*/
	public static function extractLanguage($params, $uri)
	{	
		$parts = explode('/', $uri, 2);
		if(in_array($parts[0], $params['languages'])) {
			define('LANG', $parts[0]);
		} else {
			define('LANG', $params['default']);
		}
	}
}