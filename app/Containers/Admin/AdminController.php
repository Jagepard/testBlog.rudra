<?php

namespace App\Containers\Admin;

use App\Ship\ShipController;
use Rudra\Container\Facades\Rudra;
use Rudra\View\ViewFacade as View;
use App\Containers\Tools\Translator;
use App\Containers\Tools\HelperTrait;
use Rudra\Controller\ContainerControllerInterface;
use Rudra\EventDispatcher\EventDispatcherFacade as Dispatcher;

class AdminController extends ShipController implements ContainerControllerInterface
{
    use Translator;
    use HelperTrait;

    public function containerInit(): void
    {
        $config = require_once "config.php";

        Rudra::binding()->set($config['contracts']);
        Rudra::waiting()->set($config['services']);

        Dispatcher::dispatch('RoleAccess', 'admin');
        View::setup(dirname(__DIR__) . "/Admin/UI/tmpl", "Admin_");

        data([
            "title" => __CLASS__,
        ]);

        Rudra::config()->set([
            'admin' => [
                'images_path' => Rudra::config()->get('app.path') . "/public/images/",
                'thumb_width' => 200
            ]
        ]);

        $this->info(get_called_class());
    }
}
