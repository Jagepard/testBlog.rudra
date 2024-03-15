<?php

namespace App\Containers\Auth;

use App\Ship\ShipController;
use Rudra\View\ViewFacade as View;
use Rudra\Controller\ConainersControllerInterface;

class AuthController extends ShipController implements ConainersControllerInterface
{
    public function containerInit(): void
    {
        View::setup(dirname(__DIR__) . '/', "Auth/UI/tmpl", "Auth/UI/cache");
        data(["title" => __CLASS__,]);
    }
}
