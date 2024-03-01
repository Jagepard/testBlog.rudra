<?php

namespace App\Containers\Auth\Entity;

use Rudra\Model\Entity;

/**
 * @see App\Containers\Auth\Repository\UsersRepository
 */
class Users extends Entity
{
    public static string $table = "users";
    public static string $directory = __DIR__;
}
