<?php

namespace App\Containers\Blog\Models;

use Rudra\Model\Model;

/**
 * @method static yourMethod()
 *
 * @see MaterialsRepository
 */
class Materials extends Model
{
    public static string $table = "materials";
    public static string $directory = __DIR__;
}
