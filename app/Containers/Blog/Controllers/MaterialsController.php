<?php

namespace App\Containers\Blog\Controllers;

use App\Containers\Blog\BlogController;
use App\Containers\Blog\Models\Materials;
use Rudra\Pagination;

class MaterialsController extends BlogController
{
    #[Routing(url: '', method: 'GET')]
    #[Routing(url: 'page/{page}', method: 'GET')]
    public function actionIndex(string $page = '1')
    {
        $pagination = new Pagination($page, 5, Materials::numRows());
        $paginated = Materials::getAllPerPage($pagination);

        data([
            "title"   => "title",
            "content" => view("materials/index", [
                'materials' => $paginated,
                "links"    => $pagination->getLinks(),
                "page"     => $page,
                "pg_limit" => 2
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
