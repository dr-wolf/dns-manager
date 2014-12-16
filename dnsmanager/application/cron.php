#!/usr/bin/php
<?php
    require_once(__DIR__."/core/core.php");

    $config = array(
    
        'application' => __DIR__.'/',

        'db' => array(
            'host' => 'localhost',
            'user' => 'user',
            'password' => 'password',
            'database' => 'database'
        ),

        'names' => array(
            'nameserver' => 'example.com',
            'nameserver_ip' => '192.168.0.1'
        ),

        'zone_file' => '/etc/bind/zones.conf',
        'db_path' => '/etc/bind/db/'

    );

    echo Core::cron($config, 'CronTask');



