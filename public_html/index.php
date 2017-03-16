<?php
    define('APP_PATH', __DIR__.'/../application/');
    define('FRAMEWORK_PATH', __DIR__.'/../framework/');

    require_once(FRAMEWORK_PATH.'core.php');

    echo Core::run();