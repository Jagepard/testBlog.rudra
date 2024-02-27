<?php

namespace App\Containers\Auth\Controllers;

use Rudra\Auth\AuthFacade as Auth;
use Rudra\Container\Facades\Request;
use App\Containers\Auth\Models\Login;
use App\Containers\Auth\AuthController;

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
