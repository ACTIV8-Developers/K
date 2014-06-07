<?php

namespace Core\Util;

/**
 * Class Message
 * @author miloskajnaco@gmail.com
 */
class Message {

    /**
     * @param string
     * @param mixed
     */
    public static function set($key, $value)
    {
        $_SESSION['flashmessage'][$key] = $value;
    }

    /**
     * @param string
     * @return mixed
     */
    public static function get($key)
    {
        $value = null;
        if(isset($_SESSION['flashmessage'][$key])) {
            $value = $_SESSION['flashmessage'][$key];
            unset($_SESSION['flashmessage'][$key]);
        }
        return $value;
    }
} 
