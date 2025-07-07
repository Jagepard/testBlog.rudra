<?php

namespace App\Containers\Auth\Entity;

use Rudra\Model\Entity;

/**
 * @see \App\Containers\Auth\Repository\UsersRepository
 *
 * @method static getUser(mixed $email)
 */
class Users extends Entity
{
    public static ?string $table = "users";
}
