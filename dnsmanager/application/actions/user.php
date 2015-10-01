<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class User extends BaseController
    {
        static public function add()
        {
            $error = '';
            $user = self::request('user'); 
            if($user != null){
                $error = UserDB::validate($user);                
                if($error == ''){
                    UserDB::insert($user);
                    self::redirect('/'.$user['domain_id']);    
                }
            } else
                $user = array(
                    'id' => 0,
                    'login' => '',
                    'domain_id' => self::request('d', 0)                    
                );
            return self::render('forms/user', array('user' => $user, 'error' => $error));
        }

        static public function edit()
        {
            $error = '';
            $user = self::request('user'); 
            if($user != null){ 
                $error = UserDB::validate($user, $user['password'] != '');
                if($error == ''){                         
                    UserDB::update($user);
                    if($user['password'] != '')
                        UserDB::changepass($user);
                    self::redirect('/'.$user['domain_id']);    
                }
            } else
                $user = UserDB::get(self::request('id', 0));
            return self::render('forms/user', array('user' => $user, 'error' => $error));
        }

        static public function delete()
        {
            $id = self::request('id', 0);
            if($id > 0) 
                UserDB::delete($id);     
            self::redirect('/'.self::request('d', 0));
        }
}