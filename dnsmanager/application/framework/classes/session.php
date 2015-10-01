<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class Session
    {
        public function __construct()
        {
            session_start();
        }
        
        public function exists($name)
        {
            return isset($_SESSION[$name]);
        }
        
        public function get($name, $default = null)
        {
            if(isset($_SESSION[$name])){
                return $_SESSION[$name];    
            } else {
                return $default;
            }
        }
        
        public function set($name, $value)
        {
            $_SESSION[$name] = $value;    
        }
        
        public function close()
        {
            session_destroy();
        }
        
    }