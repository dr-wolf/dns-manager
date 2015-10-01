<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * ? ENIGMA Development Laboratory, 2014
    */

    final class Cookie
    {
        const session = null;
        const day = 86400;
        const week = 604800;
        const month = 2592000;
        const year = 31536000;

        public function exists($name)
        {
            return isset($_COOKIE[$name]);
        }

        public function get($name, $default = null)
        {
            if (isset($_COOKIE[$name]))
                return $_COOKIE[$name];
            else
                return $default;
        }

        public function set($name, $value, $expiry = self::session, $path = '/')
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

        public function delete($name)
        {
            if (!headers_sent()) {
                unset($_COOKIE[$name]);
                setcookie($name, null, -1);
                return true;
            }
            return false;
        }
}