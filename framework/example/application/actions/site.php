<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class Site extends Controller 
    {
    
        static public function index()
        {         
            $model = new TableDB();
            return self::render('index', array('v' => $model->getAll()));     
        }  

    }