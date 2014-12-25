<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    define('APP_PATH', __DIR__.'/application/');

    require_once(__DIR__.'/application/framework/core.php');
    require_once(__DIR__.'/application/config.php');

    echo Core::run($config);



