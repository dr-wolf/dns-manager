#!/usr/bin/php
<?php
    define('APP_PATH', __DIR__.'/');

    require_once(__DIR__."/framework/core.php");
    require_once(__DIR__."/config.php");

    echo Core::cron($config, 'CronTask');



