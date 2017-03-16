<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */    

    class UserDB extends DB {

        public static function all($domain_id)
        {
            $sql = 'select * from `users` where `domain_id` = ? order by `login` asc'; 
            return self::$db->query($sql, array($domain_id))->fetchAll();    
        }   
        
        public static function emails()
        {
            $sql = 'select `users`.`id` as `id`, concat(`users`.`login`, "@", `domains`.`name`) as `email` 
                from `users` left join `domains` on `users`.`domain_id` = `domains`.`id` order by `email` asc'; 
            return self::$db->query($sql, array())->fetchAll();    
        }        

        public static function get($id)
        {
            $sql = 'select * from `users` where `id` = ?';                    
            return self::$db->query($sql, array($id))->fetch(); 
        }

        public static function insert($user)
        {
            $sql = 'insert into `users` (`login`, `password`, `domain_id`) values (?, md5(?), ?)';
            self::$db->query($sql, self::prepare($user, array('login', 'password', 'domain_id'))); 
        }

        public static function update($user)
        {
            $sql = 'update `users` set `login` = ?, `domain_id` = ?  where `id` = ?';
            self::$db->query($sql, self::prepare($user, array('login', 'domain_id', 'id'))); 
        }

        public static function changepass($user)
        {
            $sql = 'update `users` set `password` = md5(?) where `id` = ?';
            self::$db->query($sql, self::prepare($user, array('password', 'id'))); 
        }        

        public static function delete($user_id)
        {
            $sql = 'delete from `users` where `id` = ?';
            self::$db->query($sql, array($user_id));   
        }

        public static function validate($user, $require_password = true)
        {
            if(!preg_match('/^[a-z0-9]+[a-z0-9\-]*[a-z0-9]+(\.[a-z0-9]+[a-z0-9\-]*[a-z0-9]+)*$/ix', $user['login']))
                return 'Invalid user login!';
            if($require_password) {
                if(strlen($user['password']) < 6) 
                    return 'Password must be minimum 6 chars long!';     
                if($user['password'] != $user['password_retype'])
                    return 'Passwords are must be equals!';  
            }
            $sql = 'select count(*) as c from `users` where `id` <> ? and `login` = ? and `domain_id` = ?';    
            $r = self::$db->query($sql, self::prepare($user, array('id', 'login', 'domain_id')))->fetch(); 
            if($r['c'] > 0)
                return 'User already exists!';
            if(count(DomainDB::get($user['domain_id'])) == 0)
                return 'Parent domain not found!';
        }

    }

