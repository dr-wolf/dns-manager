<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class Cookie
    {
        const session = null;
        const day = 86400;
        const week = 604800;
        const month = 2592000;
        const year = 31536000;

        static public function exists($name)
        {
            return isset($_COOKIE[$name]);
        }

        static public function get($name, $default = '')
        {
            if (isset($_COOKIE[$name]))
                return $_COOKIE[$name];
            else
                return $default;
        }

        static public function set($name, $value, $expiry = self::session, $path = '/', $domain = false)
        {
            if (!headers_sent()) {
                if ($domain === false)
                    $domain = $_SERVER['HTTP_HOST'];
                if (is_numeric($expiry))
                    $expiry += time();
                else
                    $expiry = strtotime($expiry);
                if (@setcookie($name, $value, $expiry, $path, $domain)) {
                    $_COOKIE[$name] = $value;
                    return true;
                }
            }
            return false;
        }

        static public function delete($name, $path = '/', $domain = false, $remove_from_global = false)
        {
            if (!headers_sent()) {
                if ($domain === false)
                    $domain = $_SERVER['HTTP_HOST'];
                if ($remove_from_global)
                    unset($_COOKIE[$name]);
                if (setcookie($name, '', time() - 3600, $path, $domain))
                    return true;
            }
            return true;
        }
}