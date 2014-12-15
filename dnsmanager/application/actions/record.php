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
            if(isset($_POST['record'])){
                $record = $_POST['record'];      
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
                    'domain_id' => intval($_GET['domain'])                    
                );
            return self::render('forms/record', array('record' => $record, 'error' => $error));
        }

        static public function edit()
        {
            $error = '';
            if(isset($_POST['record'])){
                $record = $_POST['record'];      
                $error = RecordDB::validate($record);
                if($error == ''){
                    RecordDB::update($record);
                    self::redirect('/domain?id='.$record['domain_id']);    
                }
            } else
                $record = RecordDB::get(intval($_GET['id']));
            return self::render('forms/record', array('record' => $record, 'error' => $error));
        }

        static public function delete()
        {
            if(isset($_GET['id'])) {
                $record = RecordDB::get(intval($_GET['id']));
                RecordDB::delete($record);  
            }     
            self::redirect('/domain?id='.intval($_GET['domain']));
        }
}