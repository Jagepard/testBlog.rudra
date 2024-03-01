<?php

namespace App\Containers\Blog\Entity;

use Rudra\Model\Entity;

/**
 * @see App\Containers\Blog\Repository\MaterialsRepository
 */
class Materials extends Entity
{
    public static string $table = "materials";
    public static string $directory = __DIR__;
}
