#!/usr/bin/php
<?php
    define('APP_PATH', __DIR__.'/');
    define('FRAMEWORK_PATH', __DIR__.'/../framework/');

    require_once(FRAMEWORK_PATH.'/core.php');

    echo Core::cron('CronTask');