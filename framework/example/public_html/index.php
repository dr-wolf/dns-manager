<?php    
    define('APP_PATH', __DIR__.'/../application/');
    define('FRAMEWORK_PATH', '/home/www-data/frameworks/mosquito/');

    require_once(FRAMEWORK_PATH.'core.php');

    echo Core::run();
