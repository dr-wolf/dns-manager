<?php
/*
* written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
* © ENIGMA Development Laboratory, 2014
*/

final class Session
{

    private static function check() 
    {
        if (session_id() == "")
            session_start();
    }

    public static function init($session_id)
    {
        session_id($session_id);
        session_start();
    }

    public static function id() 
    {
        self::check();
        return session_id();
    }

    public static function exists($name)
    {
        self::check();
        return isset($_SESSION[$name]);
    }

    public static function get($name, $default = null)
    {
        self::check();
        if(isset($_SESSION[$name])){
            $value = $_SESSION[$name];
            if($default !== null)
                settype($value, gettype($default));
            return $value;  
        } else {
            return $default;
        }
    }

    public static function set($name, $value)
    {
        self::check();
        $_SESSION[$name] = $value;    
    }
    
    public static function delete($name)
    {
        self::check();
        unset($_SESSION[$name]);
    }

    public static function commit() {
        self::check();
        session_commit();            
    }

    public static function destroy()
    {
        self::check();
        $_SESSION = array();
        session_destroy();
    }

}