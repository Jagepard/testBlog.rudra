<?php

namespace App\Containers\Auth\Listeners;

use Rudra\Auth\AuthFacade as Auth;
use Rudra\Container\Facades\Session;
use Rudra\Redirect\RedirectFacade as Redirect;

class AccessListener
{
    /**
     * @param $role
     *
     * Access to content based on role
     * -------------------------------
     * Доступ к материалам на основании роли
     */
    public function accessToRoleResources($role)
    {
        /*
         * General authorization
         * ---------------------
         * Общая авторизация
         */
        if (!Auth::authorization()) {
            Redirect::run('login');
        }

        if (Session::has("user")) {
            /*
             * User Role Check
             * ---------------
             * Проверка роли пользователя
             */
            if (!Auth::roleBasedAccess(Session::get("user")['role'], $role)) {
                Redirect::run("", "", 401);
            }
        }
    }
}