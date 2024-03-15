<?php

namespace App\Containers\Auth\Controllers;

use Rudra\Router\Routing;
use Rudra\Auth\AuthFacade as Auth;
use App\Containers\Auth\Task\Login;
use Rudra\Container\Facades\Request;
use App\Containers\Auth\AuthController;

class LoginController extends AuthController
{
    #[Routing(url: 'login', method: 'GET')]
    public function actionIndex(): void
    {
        data(["content" => view("login")]);
        render("layout", data());
    }

    #[Routing(url: 'auth/login', method: 'POST')]
    public function login(): void
    {
        (new Login())->run((array) Request::post()->get());
    }

    #[Routing(url: 'logout')]
    public function logout(): void
    {
        Auth::exitAuthenticationSession();
    }
}
