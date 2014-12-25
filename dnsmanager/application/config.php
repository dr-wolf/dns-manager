<?php
    $config = array(

        'title' => 'DNS Manager',
        'layout' => 'layout',
        'error' => 'error',
        'debug' => true,

        'db' => array(
            'host' => 'localhost',
            'user' => 'user',
            'password' => 'password',
            'database' => 'database'
        ),

        'routes' => array(
            '/' => 'Domain.domains',
            '/urls' => 'Domain.urltree',
            '/domain' => 'Domain.view',
            '/domain/zone' => 'Domain.raw',
            '/add' => 'Domain.add',
            '/edit' => 'Domain.edit',
            '/delete' => 'Domain.delete',
            '/record/add' => 'Record.add',
            '/record/edit' => 'Record.edit',
            '/record/delete' => 'Record.delete'
        ),

        'names' => array(
            'nameserver' => 'example.com',
            'nameserver_ip' => '192.168.0.1'
        ),

        'zone_file' => '/etc/bind/zones.conf',
        'db_path' => '/etc/bind/db/'
    );