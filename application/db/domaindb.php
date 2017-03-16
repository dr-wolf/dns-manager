<?php
    
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * ? ENIGMA Development Laboratory, 2014
    */    
    
    class DomainDB extends DB {

        public static function all($order = null, $modified = false)
        {
            $sql = 'select * from `domains`'; 
            if($modified)
                $sql .= ' where `modified` = true';  
            if(in_array($order, array('id', 'name', 'ip', 'mailserver', 'modified')))
                $sql .= ' order by `'.$order.'` asc';                 
            return self::$db->query($sql, array())->fetchAll();    
        }

        public static function get($id)
        {
            $sql = 'select * from `domains` where `id` = ?';
            return self::$db->query($sql, array($id))->fetch();     
        }

        public static function insert($domain)
        {
            $sql = 'insert into `domains` (`name`, `ip`, `mailserver`, `modified`) values (?, ?, ?, 1)';
            self::$db->query($sql, self::prepare($domain, array('name', 'ip', 'mailserver')));     
        }

        public static function update($domain)
        {
            $sql = 'update `domains` set `name` = ?, `ip` = ?, `mailserver` = ? where `id` = ?';
            if(self::$db->query($sql, self::prepare($domain, array('name', 'ip', 'mailserver', 'id')))->affectedRows())   
                self::modify($domain['id']);
        }

        public static function modify($id)
        {
            $sql = 'update `domains` set `modified` = 1 where `id` = ?';
            self::$db->query($sql, array($id));
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
            self::$db->query($sql, array($id));     
        }

        public static function validate($domain)
        {
            if(!filter_var($domain['ip'], FILTER_VALIDATE_IP))
                return 'Invalid IP!';
            if(!preg_match('/^[a-z0-9]+[a-z0-9\-]*[a-z0-9]+(\.[a-z0-9]+[a-z0-9\-]*[a-z0-9]+)*\.[a-z0-9]{2,6}$/ix', $domain['name']))
                return 'Invalid domain name!';        
            $sql = 'select count(*) as c from `domains` where `id` <> ? and `name` = ?';  
            $params = array($domain['id'], $domain['name']);
            $r = self::$db->query($sql, $params)->fetch();
            if($r['c'] > 0)
                return 'Domain name is in use!';
        }

    }
