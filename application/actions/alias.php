<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class Alias extends BaseController 
    {

        static public function aliases()
        {                                            
            $aliases = AliasDB::all();                                   
            return self::render('aliases', array('aliases' => $aliases));
        }

        static public function add()
        {
            $error = '';
            $alias = self::request('alias');
            if($alias != null){   
                $error = AliasDB::validate($alias);
                if($error == ''){
                    AliasDB::insert($alias);
                    self::redirect('/aliases');    
                }
            } else
                $alias = array(
                    'id' => 0,
                    'source_id' => 0,
                    'destination' => ''                   
                );
            $emails = UserDB::emails();
            return self::render('forms/alias', array('alias' => $alias, 'error' => $error, 'emails' => $emails));
        }

        static public function edit()
        {
            $error = '';
            $alias = self::request('alias');
            if($alias != null){      
                $error = AliasDB::validate($alias);
                if($error == ''){
                    AliasDB::update($alias);
                    self::redirect('/aliases');    
                }
            } else
                $alias = AliasDB::get(intval(self::request('id')));
            $emails = UserDB::emails();
            return self::render('forms/alias', array('alias' => $alias, 'error' => $error, 'emails' => $emails));
        }

        static public function delete()
        {
            $id = self::request('id', 0);
            if($id > 0)
                AliasDB::delete($id);           
            self::redirect('/aliases');
        }
    }
