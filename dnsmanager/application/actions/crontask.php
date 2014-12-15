<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class CronTask extends Core
    {
        static private function cleardb()
        {
            $log = '';
            $files = array_filter(scandir(self::$config['db_path']), function($val){
                return !in_array($val, array('.', '..'));
            });
            $domains = array_map(function($e){ 
                return 'db.'.sprintf('%06d', $e['id']);    
                }, DomainDB::all());
            foreach(array_diff($files, $domains) as $file){
                @unlink(self::$config['db_path'].$file);
                $log .= '[info]: '.$file.' deleted'.PHP_EOL;
            }
            return $log;
        }

        static public function writedb($domain)
        {
            $records = RecordDB::all($domain['id']);
            return self::render('files/db', array('domain' => $domain, 'records' => $records, 'names' => self::$config['names']));             
        }

        static public function processqueue()
        {    
            $log = self::cleardb();
            $domains = DomainDB::all(true);
            if(count($domains) || $log != ''){
                foreach($domains as $domain){
                    file_put_contents(self::$config['db_path'].'db.'.sprintf('%06d', $domain['id']), self::writedb($domain));
                    $log .= '[info]: '.$domain['name'].' updated'.PHP_EOL;
                }        
                $domains = DomainDB::all();
                file_put_contents(self::$config['zone_file'], self::render('files/zone', array('domains' => $domains, 'path' => self::$config['db_path'])));  
                DomainDB::saveall();
                shell_exec('service bind9 restart');
            } else 
                $log .= '[info]: no file updated'.PHP_EOL;     
            return $log;                    
        }    
    }
