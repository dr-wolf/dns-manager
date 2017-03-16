<?php
/*
* written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
* ? ENIGMA Development Laboratory, 2014
*/

final class Cookie
{
    const DAY = 86400;
    const WEEK = 604800;
    const MONTH = 2592000;
    const YEAR = 31536000;

    public static function exists($name)
    {
        return isset($_COOKIE[$name]);
    }

    public static function get($name, $default = null)
    {
        if (isset($_COOKIE[$name])) {
            $value = $_COOKIE[$name];
            if($default !== null)
                settype($value, gettype($default));
            return $value;
        } else
            return $default;
    }

    public static function set($name, $value, $expiry = null, $path = '/')
    {
        if (!headers_sent()) {
            if (is_numeric($expiry))
                $expiry += time();
            else
                $expiry = strtotime($expiry);
            if (setcookie($name, $value, $expiry, $path)){ 
                $_COOKIE[$name] = $value;
                return true;    
            }
        }
        return false;
    }

    public static function delete($name)
    {
        if (!headers_sent()) {
            unset($_COOKIE[$name]);
            setcookie($name, null, -1);
            return true;
        }
        return false;
    }
}