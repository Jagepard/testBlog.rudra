<?php

namespace App\Containers\Blog\Entity;

use Rudra\Pagination;
use Rudra\Model\Entity;

/**
 * @method static numRows()
 * @method static find(string $id)
 * @method static getAllPerPage(Pagination $pagination)
 */
class Materials extends Entity
{
    public static ?string $table = "materials";
}
