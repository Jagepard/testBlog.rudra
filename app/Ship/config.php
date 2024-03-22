<?php

use Rudra\Container\Rudra;
use Rudra\Container\Request;
use DebugBar\StandardDebugBar;
use Rudra\Container\Interfaces\RudraInterface;
use Rudra\Container\Interfaces\RequestInterface;

return [
    'contracts'   => [
        RudraInterface::class   => Rudra::run(),
        // RequestInterface::class => Request::class
    ],
    'services'    => [
        "DSN" => [PDO::class, [
            Rudra::run()->config()->get('database')['dsn'], 
            Rudra::run()->config()->get('database')['username'], 
            Rudra::run()->config()->get('database')['password']]
        ],
        "debugbar" => StandardDebugBar::class
    ]
];
