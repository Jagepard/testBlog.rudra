<?php

namespace App\Containers\Admin;

use App\Ship\ShipController;
use App\Ship\Utils\Translator;
use Rudra\Container\Facades\Rudra;
use Rudra\View\ViewFacade as View;
use Rudra\Controller\ContainerControllerInterface;
use Rudra\EventDispatcher\EventDispatcherFacade as Dispatcher;

class AdminController extends ShipController implements ContainerControllerInterface
{
    use Translator;

    public function containerInit(): void
    {
        Dispatcher::dispatch('RoleAccess', 'admin');
        View::setup(dirname(__DIR__) . '/', "Admin/UI/tmpl", "Admin/UI/cache");

        data([
            "title" => __CLASS__,
        ]);

        Rudra::config()->set([
            'admin' => [
                'images_path' => Rudra::config()->get('app.path') . "/public/images/",
                'thumb_width' => 200
            ]
        ]);
    }
}
