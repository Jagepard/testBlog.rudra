<?php

namespace App\Containers\Admin\Repository;

use Rudra\Model\QBFacade;
use App\Containers\Admin\Models\Materials;
use Rudra\Container\Facades\Request;
use Rudra\Redirect\RedirectFacade as Redirect;

class MaterialsRepository
{
    public static string $table = "test";

    public static function createMaterial(string $slug): void
    {
        $fields         = Request::post()->get();
        $fields['slug'] = $slug;

        Materials::create($fields);
        Redirect::run("admin/materials");
    }

    public static function updateMaterial(string $id, string $slug): void
    {
        $fields         = Request::post()->get();
        $fields['slug'] = $slug;

        Materials::update($id, $fields);
        Redirect::run("admin/materials");
    }

    public static function deleteMaterial(): void
    {
        Materials::delete(Request::get()->get('id'));
        Redirect::run("admin/materials");
    }
}