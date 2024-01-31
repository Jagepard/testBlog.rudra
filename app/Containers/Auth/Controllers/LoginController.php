<?php

namespace App\Containers\Auth\Controllers;

use App\Containers\Auth\AuthController;
use App\Containers\Auth\Models\Login;
use Rudra\Container\Facades\Request;
use Rudra\Auth\AuthFacade as Auth;

class LoginController extends AuthController
{
    #[Routing(url: 'login', method: 'GET')]
    public function actionIndex()
    {
        data(["content" => view("login")]);
        render("layout", data());
    }

    #[Routing(url: 'auth/login', method: 'POST')]
    public function login()
    {
        Login::run(Request::post()->get());
    }

    #[Routing(url: 'logout')]
    public function logout()
    {
        Auth::exitAuthenticationSession();
    }
}
