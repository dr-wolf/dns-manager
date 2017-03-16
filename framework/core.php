<?php
require_once(__DIR__.'/classes/controller.php');
require_once(__DIR__.'/classes/db.php');
require_once(__DIR__.'/classes/mysqli.php');

/*
* written by Taras "Dr.Wolf" Supyk <w@enigma-lab.org>    
* © ENIGMA Development Laboratory, 2014
*/

final class Core 
{
    static public $config = array(
        'title' => 'Mosquito',
        'layout' => 'layout',
        'error' => 'error',
        'debug' => true,
        'default_language' => '',
        'languages' => array(
        ),
        'includes' => array(
            -1 => 'actions',
            -2 => 'db'
        ),
    );

    static public $errors = array(
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

    static private function prepare_get($matches)
    {
        $keys = array_filter(array_keys($matches), function ($k){ return !is_int($k); }); 
        return array_intersect_key($matches, array_flip($keys));
    } 

    static private function autoload($class_name)
    {
        foreach(self::$config['includes'] as $dir){
            $class_path = realpath(APP_PATH.'/'.$dir).'/'.strtolower($class_name).'.php'; 
            if(file_exists($class_path)){
                require_once($class_path);
                return 0;
            }
        }   
        $class_path = realpath(FRAMEWORK_PATH.'/helpers').'/'.strtolower($class_name).'.php'; 
        if(file_exists($class_path)){
            require_once($class_path);
            return 0;
        } 
        throw new Exception('Class "'.$class_name.'" not found!');
    }

    static private function init_framework()
    {
        spl_autoload_register(array(get_called_class(), 'autoload'));
        if(file_exists(APP_PATH.'config.json'))
            self::$config = array_replace_recursive(self::$config, json_decode(file_get_contents(APP_PATH.'config.json'), true));   
        else
            throw new Exception('Configuration file does not exists!', 500);                 
        if(self::$config['debug']){
            ini_set('display_errors', 1);
            error_reporting(E_ALL);  
        } else
            ini_set('display_errors', 0); 
        if(isset(self::$config['db']))     
            DB::init(self::$config['db']);
    }

    static public function exception($exception){
        if(isset(self::$errors[$exception->getCode()]))
            header(self::$errors[$exception->getCode()]);
        ob_clean();
        die(Controller::render(self::$config['error'], array('exception' => $exception), true));
    }     

    static public function run()
    {
        self::init_framework();   
        set_exception_handler(array(get_called_class(), 'exception'));       
        set_error_handler(function($errno, $errstr, $errfile, $errline){
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline); 
        });  

        $url = parse_url($_SERVER['REQUEST_URI']); 

        if(count(self::$config['languages'])) {
            if(preg_match('#^/('.implode('|', self::$config['languages']).')(/.*)?$#i', $url['path'], $matches)){
                Controller::$language = $matches[1];
                $url['path'] = substr($url['path'], strlen($matches[1]) + 1);
                if($url['path'] == '')
                    $url['path'] = '/';
            } else 
                Controller::$language = self::$config['default_language'];
        } 

        Controller::$uri = $url['path'];
        if(isset($url['query']))
            Controller::$uri .= '?'.$url['query'];

        foreach(self::$config['routes'] as $pattern => $controller){
            $pattern = preg_replace_callback("#{([a-z]+[a-z0-9]*):([^}]*)}#i", function($m){
                return '(?P<'.$m[1].'>'.$m[2].')';            
                }, $pattern);
            if (preg_match('#^'.$pattern.'$#i', $url['path'], $matches)) {
                if (is_array($controller)) { 
                    if(isset($controller[$_SERVER['REQUEST_METHOD']]))
                        $controller = $controller[$_SERVER['REQUEST_METHOD']]; 
                    else
                        continue; 
                }  
                list($class, $method) = explode('.', $controller);
                if(method_exists($class, $method)){
                    $_REQUEST += self::prepare_get($matches);                       
                    if(($result = $class::init()) === true)
                        return $class::$method();
                    else
                        return $result;  
                }  
            }
        }
        throw new Exception($url['path'].' is not found.', 404); 
    }

    static public function cron($class)
    {            
        self::init_framework();
        $opt = getopt('c:');
        if(isset($opt['c'])) {
            $method = $opt['c'];
            if(method_exists($class, $method)){
                $class::init();
                return $class::$method();  
            } else     
                $result = '[error]: method not found!'.PHP_EOL;   
        }else
            $result = '[error]: method is not specified!'.PHP_EOL; 
        return $result;             
    }

}