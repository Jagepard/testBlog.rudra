<?php

namespace App\Containers\Admin\Entity;

use Rudra\Model\Entity;

/**
 * @see MaterialsRepository
 */
class Materials extends Entity
{
    public static string $table     = "materials";
    public static string $directory = __DIR__;
}
