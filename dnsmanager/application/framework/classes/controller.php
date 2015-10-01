<?php

    class Controller 
    {
        static protected $title = '';
        static protected $translations = array();
        
        static public $language = '';
        static public $uri = '';

        static public function loadTranslation($file, $language = null)
        {
            if($language == null)
                $language = self::$language;
            $lines = parse_ini_file(APP_PATH.'translations/'.$language.'/'.$file.'.ini');
            self::$translations = array_replace(self::$translations, $lines);
        }
        
        static public function t($key)
        {
            if(isset(self::$translations[$key]))
                return self::$translations[$key];
            else
                return $key;
        } 
        
        static private function view()
        {                                 
            extract(func_get_arg(1));
            ob_start();
            include func_get_arg(0); 
            return ob_get_clean();
        }
        
        static private function view_path($view)
        {
            $view_path = APP_PATH.'templates/'.$view.'.php';            
            if(!file_exists($view_path)){
                $view_path = FRAMEWORK_PATH.'templates/'.$view.'.php';
                if(!file_exists($view_path)) 
                    throw new Exception('Template "'.$view.'" not found!');    
            }
            return $view_path;    
        }

        static public function render($view, $params = array(), $partial = false)      
        {                                                                                      
            if(!$partial) {
                $content = self::view(self::view_path($view), $params);
                return self::view(self::view_path(Core::$config['layout']), array('content' => $content));
            }            
            else 
                return self::view(self::view_path($view), $params);
        }
        
        static public function ajax($params = array())
        {
            header('Content-Type: application/json');
            return json_encode($params);
        }

        static protected function uri($url, $args = array())
        {
            if(self::$language != '' && self::$language != Core::$config['default_language'])
                $url = '/'.self::$language.$url;
            if(count($args) > 0)
                $url .= '?'.http_build_query($args);
            return $url;
        } 
        
        static protected function redirect($url)
        {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$url);
            die();
        }

        static protected function request($value, $default = null)
        {
            if(isset($_REQUEST[$value])) {
                $value = $_REQUEST[$value];
                if($default !== null)
                    settype($value, gettype($default));
                return $value;
            } else
                return $default;
        }

        static public function init()
        {
            // Should be overrided in child classes
        }
}