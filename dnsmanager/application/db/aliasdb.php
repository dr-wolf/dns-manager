<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */    

    class AliasDB extends DB {

        public static function all($order = null)
        {
            $sql = 'select `aliases`.`id` as `id`, concat(`users`.`login`, "@", `domains`.`name`) as `email`, `aliases`.`destination` as `destination`  
                from `aliases` left join `users` on `aliases`.`source_id` = `users`.`id` left join `domains` on `users`.`domain_id` = `domains`.`id`'; 
            if(in_array($order, array('id', 'email', 'destination')))
                $sql .= ' order by `'.$order.'` asc';   
            return self::$db->query($sql, array())->fetchAll();    
        }   

        public static function get($id)
        {
            $sql = 'select * from `aliases` where `id` = ?';                    
            return self::$db->query($sql, array($id))->fetch(); 
        }

        public static function insert($alias)
        {
            $sql = 'insert into `aliases` (`source_id`, `destination`) values (?, ?)';
            self::$db->query($sql, self::prepare($alias, array('source_id', 'destination'))); 
        }

        public static function update($alias)
        {
            $sql = 'update `aliases` set `source_id` = ?, `destination` = ?  where `id` = ?';
            self::$db->query($sql, self::prepare($alias, array('source_id', 'destination', 'id'))); 
        }
 
        public static function delete($alias_id)
        {
            $sql = 'delete from `aliases` where `id` = ?';
            self::$db->query($sql, array($alias_id));   
        }

        public static function validate($alias)
        {
            if(UserDB::get($alias['source_id']) == null)
                return 'Select user email!';
            if(!filter_var($alias['destination'], FILTER_VALIDATE_EMAIL)) 
                return 'Invalid redirect email!';
        }

    }

