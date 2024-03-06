<?php

namespace App\Containers\Blog\Controller;

use Rudra\Pagination;
use Rudra\Exceptions\RouterException;
use App\Containers\Blog\BlogController;
use App\Containers\Blog\Entity\Materials;

class MaterialsController extends BlogController
{
    #[Routing(url: '', method: 'GET')]
    #[Routing(url: 'page/{page}', method: 'GET')]
    public function actionIndex(string $page = '1')
    {
        $pagination = new Pagination($page, 5, Materials::numRows());
        $paginated  = Materials::getAllPerPage($pagination);

        data([
            "title"   => data('title') . __METHOD__,
            "content" => view("materials/index", [
                'materials' => $paginated,
                "links"     => $pagination->getLinks(),
                "page"      => $page,
                "pg_limit"  => 2
            ]),
        ]);

        render("layout", data());
    }

    #[Routing(url: 'material/:slug')]
    public function item(string $slug)
    {
        $id       = $this->getIdFromSlug($slug);
        $material = Materials::find($id);

        $this->handle404($material);

        data([
            "title"   => $material['title'],
            "content" => view("materials/item", [
                'material' => $material,
            ]),
        ]);

        render("layout", data());
    }
}
