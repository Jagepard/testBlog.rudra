<?php

namespace App\Ship;

use App\Ship\Utils\HelperTrait;
use Rudra\Controller\Controller;
use Rudra\Container\Facades\Rudra;
use App\Containers\Auth\Listeners\AccessListener;
use Rudra\EventDispatcher\EventDispatcherFacade as Dispatcher;

class ShipController extends Controller
{
    use HelperTrait;

    public function shipInit()
    {
        if (Rudra::config()->get("environment") === "development") {
            Rudra::get("debugbar")['time']->stopMeasure('routing');
            data([
                "debugbar" => Rudra::get("debugbar")->getJavascriptRenderer(),
            ]);
        }

        Dispatcher::addListener('RoleAccess', [AccessListener::class, 'accessToRoleResources']);
    }
}
