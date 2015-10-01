<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class Domain extends BaseController 
    {

        static public function domains()
        {                                            
            $domains = DomainDB::all(self::request('order', 'id'));                                   
            return self::render('domains', array('domains' => $domains));
        }

        static public function urltree()
        {           
            $domains = DomainDB::all('name');
            foreach($domains as $key => $domain){
                $records = RecordDB::all($domain['id'], 'name');
                if(count($records))
                    $domains[$key]['records'] = $records;  
            }
            return self::render('urltree', array('domains' => $domains));
        }

        static public function view()
        {                    
            $domain = DomainDB::get(self::request('id', 0));
            $records = RecordDB::all($domain['id'], self::request('order', 'name'));
            $users = UserDB::all($domain['id']);
            return self::render('view', array('domain' => $domain, 'records' => $records, 'users' => $users));
        }        

        static public function raw()
        {                      
            $domain = DomainDB::get(self::request('id'), 0);
            header('Content-type: text/plain');
            return CronTask::writedb($domain);
        } 

        static public function add()
        {
            $error = '';
            $domain = self::request('domain');
            if($domain != null){   
                $error = DomainDB::validate($domain);
                if($error == ''){
                    DomainDB::insert($domain);
                    self::redirect('/');    
                }
            } else
                $domain = array(
                    'id' => 0,
                    'name' => '',
                    'ip' => '',
                    'mailserver' => 0                    
                );
            return self::render('forms/domain', array('domain' => $domain, 'error' => $error));
        }

        static public function edit()
        {
            $error = '';
            $domain = self::request('domain');
            if($domain != null){      
                $error = DomainDB::validate($domain);
                if($error == ''){
                    DomainDB::update($domain);
                    self::redirect('/'.$domain['id']);    
                }
            } else
                $domain = DomainDB::get(intval(self::request('id')));
            return self::render('forms/domain', array('domain' => $domain, 'error' => $error));
        }

        static public function delete()
        {
            $id = self::request('id', 0);
            if($id > 0)
                DomainDB::delete($id);           
            self::redirect('/');
        }
    }
