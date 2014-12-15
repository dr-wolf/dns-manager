<?php
    require_once(__DIR__."/mysqli.php");

    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class DB {
        protected static $db = null;

        public static function init($db)
        {
            if (!is_object(DB::$db)) 
                self::$db = new DataBase($db['host'], $db['user'], $db['password'], $db['database']);       
        }

        public function __call($method, $args) {
            if(method_exists(get_called_class(), $method)) {
                if (!is_object(self::$db)) 
                    throw new Exception('Database is not initialized!'); 
                call_user_func_array(array(get_called_class(), $method), $args);
            }
        }
}