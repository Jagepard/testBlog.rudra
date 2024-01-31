<?php

namespace App\Containers\Auth\Models;

use Rudra\Model\Model;

/**
 * @method static getUser(string $email)
 *
 * @see UsersRepository
 */
class Users extends Model
{
    public static string $table = "users";
    public static string $directory = __DIR__;
}  