<?php

namespace App\Containers\Admin\Controller\Facaded;

use Rudra\Pagination;
use Rudra\Container\Facades\Request;
use App\Containers\Admin\AdminController;
use App\Containers\Admin\Entity\Materials;

class MaterialsController extends AdminController
{
    #[Routing(url: 'admin', method: 'GET')]
    #[Routing(url: 'admin/materials', method: 'GET')]
    #[Routing(url: 'admin/materials/:page', method: 'GET')]
    public function materials(string $page = '1'): void
    {
        $pagination = new Pagination($page, 5, Materials::numRows());
        $paginated  = Materials::getAllPerPage($pagination);

        data([
            "title"   => "title",
            "content" => view("materials/index", [
                'materials' => $paginated,
                "links"     => $pagination->getLinks(),
                "page"      => $page,
                "pg_limit"  => 2
            ]),
        ]);

        render("layout", data());
    }

    #[Routing(url: 'admin/material/add')]
    public function add(): void
    {
        data([
            "title"   => 'Добавить',
            "content" => view("materials/add")
        ]);

        render("layout", data());
    }

    #[Routing(url: 'admin/material/create', method: 'POST')]
    public function create(): void
    {
        Materials::createMaterial($this->translit(Request::post()->get('title')));
    }

    #[Routing(url: 'admin/material/edit/:slug')]
    public function edit(string $slug): void
    {
        $material = Materials::find($this->getIdFromSlug($slug));

        data([
            "title"   => $material['title'],
            "content" => view("materials/edit", [
                'material' => $material,
                'redirect' => Request::server()->get('HTTP_REFERER')
            ]),
        ]);

        render("layout", data());
    }

    #[Routing(url: 'admin/material/update/:slug', method: 'POST')]
    public function update(string $slug): void
    {
        Materials::updateMaterial($this->getIdFromSlug($slug), $this->translit(Request::post()->get('title')));
    }

    #[Routing(url: 'admin/material/delete', method: 'GET')]
    public function delete(): void
    {
        Materials::deleteMaterial();
    }

    #[Routing(url: 'admin/material/delimg', method: 'GET')]
    public function delimg(): void
    {
        Materials::delImgMaterial();
    }
}
