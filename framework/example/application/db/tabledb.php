<?php   
   
   /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * (c) ENIGMA Development Laboratory, 2015
    */    

    class TableDB extends DB {

        public static function getAll(){
            return self::$db->query('SELECT 1, 2, 3', array())->fetchAll(); 
        }      
    }