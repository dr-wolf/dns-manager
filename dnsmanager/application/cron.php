#!/usr/bin/php
<?php
    define('APP_PATH', __DIR__.'/');

    require_once('/home/www-data/frameworks/mosquito/core.php');

    echo Core::cron('CronTask');



