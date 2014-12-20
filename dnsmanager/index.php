<?php
  
    require_once(__DIR__.'/application/core/core.php');

    $config = array(
    
        'application' => __DIR__.'/application/',
        'layout' => 'layout',
    
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
        )
        
    );

    echo Core::run($config);



