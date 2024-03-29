<?php

namespace App\Containers\Auth\Task;

use Rudra\Auth\AuthFacade as Auth;
use Rudra\Container\Facades\Session;
use App\Containers\Auth\Entity\Users;
use Rudra\Redirect\RedirectFacade as Redirect;
use Rudra\Validation\ValidationFacade as Validation;

class Login
{
    public function run(array $inputData): void
    {
        $processed = $this->validate($inputData);
        $validated = Validation::getValidated($processed, ['csrf_field']);

        if (Validation::approve($processed)) {
            $user = Users::getUser($validated['email']);

            if (!$user) {
                Session::setFlash('alert', ['not-registered' => 'Email не зарегистрирован']);
                Redirect::run('login');
            }

            Auth::authentication($user[0], $validated['password'], "admin", "Укажите верные данные");
        }

        Session::setFlash('value', $validated);
        Session::setFlash('alert', Validation::getAlerts($processed, ['csrf_field']));
        Redirect::run('login');
    }

    private function validate(array $inputData): array
    {
        return [
            'csrf_field' => Validation::sanitize($inputData['csrf_field'])->csrf(Session::get('csrf_token'))->run(),
            'email'      => Validation::email($inputData['email'], 'Почта указана неверно')->run(),
            'password'   => Validation::sanitize($inputData['password'])
                ->min(3, 'Пароль слишком мал')
                ->max(20, 'Пароль слишком большой')->run(),
        ];
    }
}
