<?php

use Rudra\Container\Facades\Rudra;
use Rudra\Router\RouterFacade as Router;
use Rudra\EventDispatcher\EventDispatcherFacade as Dispatcher;

if (php_sapi_name() != "cli") {
    Router::get("callable/:name", function ($name) {
            echo "Hello $name!";
        }
    );
}

return [

    // \App\Containers\Admin\Controller\Facaded\MaterialsController::class,
    \App\Containers\Admin\Controller\Autowired\MaterialsController::class,
];