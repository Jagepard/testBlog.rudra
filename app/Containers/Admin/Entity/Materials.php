<?php

namespace App\Containers\Admin\Entity;

use Rudra\Pagination;
use Rudra\Model\Entity;
use Rudra\Model\Repository;

/**
 * @see Repository
 *
 * @method static numRows()
 * @method static deleteMaterial()
 * @method static delImgMaterial()
 * @method static find(string $getIdFromSlug)
 * @method static createMaterial(mixed $translit)
 * @method static getAllPerPage(Pagination $pagination)
 * @method static updateMaterial(string $getIdFromSlug, mixed $translit)
 */
class Materials extends Entity
{
    public static ?string $table  = "materials";
}
