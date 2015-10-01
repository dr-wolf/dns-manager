<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * ? ENIGMA Development Laboratory, 2014
    */    
    
    class RecordDB extends DB {

        public static $types = array('A', 'CNAME');

        public static function all($domain_id, $order = null)
        {
            $sql = 'select * from `records` where `domain_id` = ?'; 
            if(in_array($order, array('name', 'target', 'type')))
                $sql .= ' order by `'.$order.'` asc';                   
            return self::$db->query($sql, array($domain_id))->fetchAll();    
        }

        public static function get($id)
        {
            $sql = 'select * from `records` where `id` = ?';                    
            return self::$db->query($sql, array($id))->fetch(); 
        }

        public static function insert($record)
        {
            $sql = 'insert into `records` (`name`, `type`, `target`, `domain_id`) values (?, ?, ?, ?)';
            if(self::$db->query($sql, self::prepare($record, array('name', 'type', 'target', 'domain_id')))->affectedRows())
                DomainDB::modify($record['domain_id']);   
        }

        public static function update($record)
        {
            $sql = 'update `records` set `name` = ?, `type` = ?, `target` = ? where `id` = ?';
            if(self::$db->query($sql, self::prepare('name', 'type', 'target', 'id'))->affectedRows()) 
                DomainDB::modify($record['domain_id']);     
        }

        public static function delete($record)
        {
            $sql = 'delete from `records` where `id` = ?';
            if(self::$db->query($sql, array($record['id']))->affectedRows()) 
                DomainDB::modify($record['domain_id']);  
        }

        public static function clear($domain_id)
        {
            $sql = 'delete from `records` where `domain_id` = ?';
            self::$db->query($sql, array($domain_id));          
        }

        public static function validate($record)
        {
            if(!preg_match('/^[a-z0-9]+[a-z0-9\-]*[a-z0-9]+(\.[a-z0-9]+[a-z0-9\-]*[a-z0-9]+)*$/ix', $record['name']))
            return "Invalid record name!";
            switch(intval($record['type'])){
                case 0:
                    if(!filter_var($record['target'], FILTER_VALIDATE_IP))
                        return "Invalid target, must be IP!";
                    break;
                case 1:
                    if(!preg_match('/^[a-z0-9]+[a-z0-9\-]*[a-z0-9]+(\.[a-z0-9]+[a-z0-9\-]*[a-z0-9]+)*\.[a-z0-9]{2,6}$/ix', $record['target']) && $record['target'] != '@')
                        return "Invalid target, must be domain!";
                    break;
                default:
                    return "Invalid record type!";
            }
            $sql = 'select count(*) as c from `records` where `id` <> ? and `name` = ? and `domain_id` = ?';
            $params = array($record['id'], $record['name'], $record['domain_id']);        
            $r = self::$db->query($sql, $params)->fetch(); 
            if($r['c'] > 0)
                return "Record already exists!";
            if(count(DomainDB::get($record['domain_id'])) == 0)
                return "Parent domain not found!";
        }

    }

