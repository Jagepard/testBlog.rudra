<?php

namespace App\Containers\Blog\Controllers;

use App\Containers\Blog\BlogController;
use App\Containers\Blog\Models\Materials;

class MaterialsController extends BlogController
{
    #[Routing(url: '', method: 'GET')]
    public function actionIndex()
    {
        data([
            "title"   => "title",
            "content" => view("materials/index", [
                'materials' => Materials::getAll(),
            ]),
        ]);

        render("layout", data());
    }

    #[Routing(url: 'material/{slug}')]
    public function item(string $slug)
    {
        $id       = $this->getIdFromSlug($slug);
        $material = Materials::find($id);

        data([
            "title"   => $material['title'],
            "content" => view("materials/item", [
                'material' => $material,
            ]),
        ]);

        render("layout", data());
    }
}
