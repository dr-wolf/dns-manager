<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class Domain extends Core 
    {

        static public function domains()
        {           
            $domains = DomainDB::all();
            return self::render('domains', array('domains' => $domains));
        }

        static public function urltree()
        {           
            function cmp($a, $b){
                if ($a['name'] == $b['name']) 
                    return 0;
                return ($a['name'] < $b['name']) ? -1 : 1;
            }

            $domains = DomainDB::all();
            usort($domains, 'cmp');
            foreach($domains as $key => $domain){
                $records = RecordDB::all($domain['id']);
                if(count($records)){
                    usort($records, 'cmp');
                    $domains[$key]['records'] = $records;
                }    
            }
            return self::render('urltree', array('domains' => $domains));
        }

        static public function view()
        {           
            $domain = DomainDB::get(intval($_GET['id']));
            $records = RecordDB::all($domain['id']);
            return self::render('view', array('domain' => $domain, 'records' => $records));
        }        

        static public function raw()
        {           
            header('Content-type: text/plain');
            $domain = DomainDB::get(intval($_GET['id']));
            echo Cron::writedb($domain);
            die();
        } 

        static public function add()
        {
            $error = '';
            if(isset($_POST['domain'])){
                $domain = $_POST['domain'];      
                $error = DomainDB::validate($domain);
                if($error == ''){
                    DomainDB::insert($domain);
                    self::redirect('/');    
                }
            } else
                $domain = array(
                    'id' => 0,
                    'name' => '',
                    'ip' => ''                    
                );
            return self::render('forms/domain', array('domain' => $domain, 'error' => $error));
        }

        static public function edit()
        {
            $error = '';
            if(isset($_POST['domain'])){
                $domain = $_POST['domain'];      
                $error = DomainDB::validate($domain);
                if($error == ''){
                    DomainDB::update($domain);
                    self::redirect('/');    
                }
            } else
                $domain = DomainDB::get(intval($_GET['id']));
            return self::render('forms/domain', array('domain' => $domain, 'error' => $error));
        }

        static public function delete()
        {
            if(isset($_GET['id']))
                DomainDB::delete(intval($_GET['id']));           
            self::redirect('/');
        }
    }
