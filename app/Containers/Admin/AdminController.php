<?php

namespace App\Containers\Admin;

use App\Ship\ShipController;
use App\Ship\Utils\Translator;
use Rudra\View\ViewFacade as View;

class AdminController extends ShipController
{
    use Translator;

    public function init()
    {
        View::setup(dirname(__DIR__) . '/', "Admin/UI/tmpl", "Admin/UI/cache");

        data([
            "title" => __CLASS__,
        ]);
    }
}
