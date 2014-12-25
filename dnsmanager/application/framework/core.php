<?php
    require_once(__DIR__.'/classes/controller.php');
    require_once(__DIR__.'/classes/db.php');
    require_once(__DIR__.'/classes/mysqli.php');
    require_once(__DIR__.'/classes/cookie.php');

    function autoload_controller($class_name)
    {
        $class_path = APP_PATH.'/actions/'.strtolower($class_name).'.php';
        if(file_exists($class_path))
            require_once($class_path);
    }  

    function autoload_model($class_name)
    {
        $class_path = APP_PATH.'/db/'.strtolower($class_name).'.php';
        if(file_exists($class_path))
            require_once($class_path);
    }

    function autoload_helper($class_name)
    {
        $class_path = APP_PATH.'/helpers/'.strtolower($class_name).'.php';
        if(file_exists($class_path))
            require_once($class_path);
        else
            throw new Exception('Class "'.$class_name.'" not found!');
    }    

    spl_autoload_register('autoload_controller');
    spl_autoload_register('autoload_model');
    spl_autoload_register('autoload_helper');

    /*
    * written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
    * © ENIGMA Development Laboratory, 2014
    */

    final class Core 
    {
        static private $cookie = null;
        static public $config = array();

        static private $errors = array(
            300 => 'HTTP/1.1 300 Multiple Choices',
            301 => 'HTTP/1.1 301 Moved Permanently',
            302 => 'HTTP/1.1 302 Found',
            303 => 'HTTP/1.1 303 See Other',
            304 => 'HTTP/1.1 304 Not Modified',
            305 => 'HTTP/1.1 305 Use Proxy',
            307 => 'HTTP/1.1 307 Temporary Redirect',
            400 => 'HTTP/1.1 400 Bad Request',
            401 => 'HTTP/1.1 401 Unauthorized',
            402 => 'HTTP/1.1 402 Payment Required',
            403 => 'HTTP/1.1 403 Forbidden',
            404 => 'HTTP/1.1 404 Not Found',
            405 => 'HTTP/1.1 405 Method Not Allowed',
            406 => 'HTTP/1.1 406 Not Acceptable',
            407 => 'HTTP/1.1 407 Proxy Authentication Required',
            408 => 'HTTP/1.1 408 Request Time-out',
            409 => 'HTTP/1.1 409 Conflict',
            410 => 'HTTP/1.1 410 Gone',
            411 => 'HTTP/1.1 411 Length Required',
            412 => 'HTTP/1.1 412 Precondition Failed',
            413 => 'HTTP/1.1 413 Request Entity Too Large',
            414 => 'HTTP/1.1 414 Request-URI Too Large',
            415 => 'HTTP/1.1 415 Unsupported Media Type',
            416 => 'HTTP/1.1 416 Requested range not satisfiable',
            417 => 'HTTP/1.1 417 Expectation Failed',
            500 => 'HTTP/1.1 500 Internal Server Error',
            501 => 'HTTP/1.1 501 Not Implemented',
            502 => 'HTTP/1.1 502 Bad Gateway',
            503 => 'HTTP/1.1 503 Service Unavailable',
            504 => 'HTTP/1.1 504 Gateway Time-out'
        );   

        static public function exception($exception){
            if(isset(self::$errors[$exception->getCode()]))
                header(self::$errors[$exception->getCode()]);
            die(Controller::render(self::$config['error'], array('exception' => $exception)));
        }

        static public function cookie()
        {
            if (self::$cookie == null)
                self::$cookie = new Cookie();
            return self::$cookie;
        }

        static public function run($config)
        {
            self::$config = $config;
            if(self::$config['debug']){
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
            }
            set_exception_handler(array(get_called_class(), 'exception'));       
            set_error_handler(function($errno, $errstr, $errfile, $errline){
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline); 
            });       
            DB::init(self::$config['db']);
            $url = parse_url($_SERVER['REQUEST_URI']);
            if(!isset($url['query']))
                $url['query'] = '';
            foreach(self::$config['routes'] as $pattern => $controller)
                if($pattern == $url['path']){
                    list($class, $method) = explode('.', $controller);
                    if(method_exists($class, $method)){
                        $class::before();
                        $content = $class::$method();  
                    }  
                    break;
                }
                if(!isset($content))
                throw new Exception($url['path'].' is not found.', 404);
            return Controller::render(self::$config['layout'], array('content' => $content));  
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