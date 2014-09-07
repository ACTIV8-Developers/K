<?php 
namespace Core\Util;

/**
* Utility class.
*
* @author Milos Kajnaco <miloskajnaco@gmail.com>
*/
class Util
{
	/**
	* Variable for caching baseUrl() call, since often it is called multiple times.
	* @var string
	*/
	protected static $base = null;

	/**
     * Deprecated, left for backward compatibility.
	 * Get site base url. (Alias of base)
	 * @param  string
	 * @return string
	 */
	public static function baseUrl($path = '')
	{
		// Check for cached version of base path
		if (null !== self::$base) {
			return self::$base.$path;
		}

        return self::base($path);
	}

    /**
     * Get site base url.
     * @param  string
     * @return string
     */
    public static function base($path = '')
    {
        // Check for cached version of base path
        if (null !== self::$base) {
            return self::$base.$path;
        }

        if (isset($_SERVER['HTTP_HOST'])) {
            $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $base_url .= '://'. $_SERVER['HTTP_HOST'];
            $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
            self::$base = $base_url;
            return $base_url.$path;
        }
        return '';
    }

	/**
	 * Get CSS file path.
	 * @param  string
	 * @return string
	 */
	public static function css($css)
	{
		return self::$base.PUBLIC_DIR.'/css/'.$css;
	}	

	/**
	 * Get JavaScript file path.
	 * @param  string
	 * @return string
	 */
	public static function js($js)
	{
		return self::$base.PUBLIC_DIR.'/js/'.$js;
	}

	/**
	 * Get image file path.
	 * @param  string
	 * @return string
	 */
	public static function img($img)
	{
		return self::$base.PUBLIC_DIR.'/images/'.$img;
	}

	/**
	 * Converts from ISO 8601 (yy-mm-dd) to dd-mm-yy format and vice-versa.
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
	 * Converts from ISO 8601 (yy-mm-dd) to serbian display date
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