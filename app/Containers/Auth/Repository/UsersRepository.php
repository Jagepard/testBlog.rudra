<?php

namespace App\Containers\Auth\Repository;

use Rudra\Model\QBFacade;
use App\Containers\Auth\Models\Users;

class UsersRepository
{
    public static string $table = "users";

    public static function getUser(string $email)
    {
        $qString = QBFacade::select()
            ->from(self::$table)
            ->where("email = :email")
            ->get();

        return Users::qBuilder($qString, [
            ':email' => $email,
        ]);
    }
}
