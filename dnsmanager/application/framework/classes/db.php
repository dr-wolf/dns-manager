<?php

    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * ? ENIGMA Development Laboratory, 2014
    */

    class DB {
        protected static $db = null;

        public static function init($db)
        {
            if (!is_object(DB::$db)) 
                self::$db = new DataBase($db['host'], $db['user'], $db['password'], $db['database']);  
            if(isset($db['encoding']))
                self::$db->query('set character set '.$db['encoding'], array());  
        }

        public static function setloc($locale)
        {
            if (is_object(DB::$db))
                self::$db->query('set lc_time_names = '.$locale, array());    
        }

        protected static function prepare($params, $order = null)
        {
            $result = array();
            if($order != null) { 
                foreach($order as $key)
                    if(isset($params[$key]))
                        array_push($result, $params[$key]);
                    else
                        array_push($result, null);
            } else 
                foreach($params as $param)
                    array_push($result, $param); 
            return $result;
        }

        public function __call($method, $args) {
            if(method_exists(get_called_class(), $method)) {
                if (!is_object(self::$db)) 
                    throw new Exception('Database is not initialized!'); 
                call_user_func_array(array(get_called_class(), $method), $args);
            }
        }
}