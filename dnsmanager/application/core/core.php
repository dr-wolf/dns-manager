<?php
    require_once(__DIR__.'/db.php');

    function __autoload($class_name) {       
        if(preg_match('#DB$#', $class_name))
            $class_path = realpath(__DIR__.'/../db');
        else
            $class_path = realpath(__DIR__.'/../actions');
        $class_path .= '/'.strtolower($class_name).'.php';
        if(file_exists($class_path))
            include($class_path);
    }  

    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    class Core 
    {

        static protected $config = array();

        static public $title = 'DNS Manager';

        static private function view()
        {
            extract(func_get_arg(1));
            include func_get_arg(0); 
        }

        static protected function render($view, $params = array())
        {
            ob_start();
            self::view(self::$config['application'].'templates/'.$view.'.php', $params);
            return ob_get_clean();
        }

        static protected function redirect($url)
        {
            header('Location: '.$url);
            die();
        }

        static protected function error404()
        {
            header('HTTP/1.0 404 Not Found');
            echo '<h1>404: Not Found</h1>';
            die();
        }
        
        static public function request($value, $default = null){
            if(isset($_REQUEST[$value])) {
                $value = $_REQUEST[$value];
                if($default !== null)
                    settype($value, gettype($default));
                return $value;
            } else
                return $default;
        }

        static public function run($config)
        {
            self::$config = $config;
            DB::init(self::$config['db']);
            $url = parse_url($_SERVER['REQUEST_URI']);
            if(!isset($url['query']))
                $url['query'] = '';
            foreach(self::$config['routes'] as $pattern => $controller)
                if($pattern == $url['path']){
                    list($class, $method) = explode('.', $controller);
                    if(method_exists($class, $method))
                        $content = $class::$method();    
                    break;
                }
                if(!isset($content))
                self::error404();
            return self::render(self::$config['layout'], array('content' => $content, 'title' => self::$title));  
        }

        static public function cron($config, $class)
        {
            self::$config = $config;
            DB::init(self::$config['db']);
            $opt = getopt('c:');
            if(isset($opt['c'])) 
                $method = $opt['c'];
            else
                $result = '[error]: method is not specified!'.PHP_EOL;
            $result = '[error]: method not found!'.PHP_EOL;
            if(method_exists($class, $method))
                $result = $class::$method();                      
            return $result;   
        }

}