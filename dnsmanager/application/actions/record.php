<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class Record extends Core
    {
        static public function add()
        {
            $error = '';
            $record = self::request('record'); 
            if($record != null){
                $error = RecordDB::validate($record);                
                if($error == ''){
                    RecordDB::insert($record);
                    self::redirect('/domain?id='.$record['domain_id']);    
                }
            } else
                $record = array(
                    'id' => 0,
                    'name' => '',
                    'type' => 0,
                    'target' => '@',
                    'domain_id' => self::request('domain', 0)                    
                );
            return self::render('forms/record', array('record' => $record, 'error' => $error));
        }

        static public function edit()
        {
            $error = '';
            $record = self::request('record'); 
            if($record != null){ 
                $error = RecordDB::validate($record);
                if($error == ''){
                    RecordDB::update($record);
                    self::redirect('/domain?id='.$record['domain_id']);    
                }
            } else
                $record = RecordDB::get(self::request('id', 0));
            return self::render('forms/record', array('record' => $record, 'error' => $error));
        }

        static public function delete()
        {
            $id = self::request('id', 0);
            if($id > 0) 
                RecordDB::delete(RecordDB::get($id));     
            self::redirect('/domain?id='.self::request('domain', 0));
        }
}