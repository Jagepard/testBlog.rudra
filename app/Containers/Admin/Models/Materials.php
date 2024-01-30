<?php

namespace App\Containers\Admin\Models;

use Rudra\Model\Model;

/**
 * @method static void createMaterial(string $slug)
 * @method static void updateMaterial(string $id, string $slug)
 * @method static void deleteMaterial()
 * 
 * @see MaterialsRepository
 */
class Materials extends Model
{
    public static string $table = "materials";
    public static string $directory = __DIR__;
} 
