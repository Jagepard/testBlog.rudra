<?php

namespace App\Ship;

use App\Ship\Utils\HelperTrait;
use Rudra\Controller\Controller;
use Rudra\Container\Facades\Rudra;
use Rudra\Controller\ShipControllerInterface;
use App\Containers\Auth\Listener\AccessListener;
use Rudra\EventDispatcher\EventDispatcherFacade as Dispatcher;

class ShipController extends Controller implements ShipControllerInterface
{
    use HelperTrait;

    public function shipInit(): void
    {
        if (Rudra::config()->get("environment") === "development") {
            
            Rudra::get("debugbar")['time']->stopMeasure('routing');
            Rudra::get("debugbar")['time']->stopMeasure('application');

            data([
                "debugbar" => Rudra::get("debugbar")->getJavascriptRenderer(),
            ]);
        }

        $this->eventRegistration();
    }

    public function eventRegistration(): void
    {
        Dispatcher::addListener('RoleAccess', [AccessListener::class, 'accessToRoleResources']);
    }
}
