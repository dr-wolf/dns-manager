<?php

    class Controller 
    {
        static protected $title = '';
        
        static private function view()
        {
            extract(func_get_arg(1));
            include func_get_arg(0); 
        }

        static public function render($view, $params = array())
        {
            $view_path = APP_PATH.'templates/'.$view.'.php';            
            if(!file_exists($view_path)){
                $view_path = __DIR__.'/../templates/'.$view.'.php';
                if(!file_exists($view_path)) 
                    throw new Exception('Template "'.$view.'" not found!');    
            }                         
            ob_start();
            self::view($view_path, $params);
            return ob_get_clean();
        }

        static protected function redirect($url)
        {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$url);
            die();
        }

        static protected function request($value, $default = null){
            if(isset($_REQUEST[$value])) {
                $value = $_REQUEST[$value];
                if($default !== null)
                    settype($value, gettype($default));
                return $value;
            } else
                return $default;
        }
        
        static public function before()
        {
            
        }
}