<?php
    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class BaseController extends Controller 
    {

        static public function init()
        {
            self::$title = 'DNS Manager';
            return true;
        }
    }