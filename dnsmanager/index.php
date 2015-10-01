<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    define('APP_PATH', __DIR__.'/application/');
    define('FRAMEWORK_PATH', __DIR__.'/application/framework/');

    require_once(FRAMEWORK_PATH.'core.php');

    echo Core::run();



