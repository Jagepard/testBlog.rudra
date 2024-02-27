<?php

namespace App\Containers\Auth;

use App\Ship\ShipController;
use Rudra\View\ViewFacade as View;

class AuthController extends ShipController
{
    public function containerInit()
    {
        View::setup(dirname(__DIR__) . '/', "Auth/UI/tmpl", "Auth/UI/cache");

        data([
            "title" => __CLASS__,
        ]);
    }
}