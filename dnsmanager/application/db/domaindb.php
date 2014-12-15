<?php
    define('RX_SUB', '[a-z0-9]+[a-z0-9\-]*[a-z0-9]');
    define('RX_END', '[a-z0-9]{2,6}');
    
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */    
    
    class DomainDB extends DB {

        public static function all($modified = false)
        {
            $sql = 'select * from `domains`'; 
            if($modified)
                $sql .= ' where `modified` = true';                   
            return self::$db->query($sql, array())->fetchAll();    
        }

        public static function get($id)
        {
            $sql = 'select * from `domains` where `id` = ?';
            $params = array($id);
            return self::$db->query($sql, $params)->fetch();     
        }

        public static function insert($domain)
        {
            $sql = 'insert into `domains` (`name`, `ip`, `modified`) values (?, ?, 1)';
            unset($domain['id']);
            self::$db->query($sql, $domain);     
        }

        public static function update($domain)
        {
            $sql = 'update `domains` set `name` = ?, `ip` = ? where `id` = ?';
            if(self::$db->query($sql, $domain)->affectedRows())   
                self::modify($domain['id']);
        }

        public static function modify($id)
        {
            $sql = 'update `domains` set `modified` = 1 where `id` = ?';
            $params = array($id);
            self::$db->query($sql, $params);
        }

        public static function saveall()
        {
            $sql = 'update `domains` set `modified` = 0';
            self::$db->query($sql, array());
        }

        public static function delete($id)
        {            
            RecordDB::clear($id);
            $sql = 'delete from `domains` where `id` = ?';  
            $params = array($id);        
            self::$db->query($sql, $params);     
        }

        public static function validate($domain)
        {
            if(!filter_var($domain['ip'], FILTER_VALIDATE_IP))
                return "Invalid IP!";
            if(!preg_match('/^'.RX_SUB.'(\.'.RX_SUB.')*\.'.RX_END.'$/ix', $domain['name']))
                return "Invalid domain name!";        
            $sql = 'select count(*) as c from `domains` where `id` <> ? and `name` = ?';  
            $params = array($domain['id'], $domain['name']);
            $r = self::$db->query($sql, $params)->fetch();
            if($r['c'] > 0)
                return "Domain name is in use!";
        }

    }
