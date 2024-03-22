<?php

namespace App\Containers\Admin\Controller\Autowired;

use Rudra\Pagination;
use App\Containers\Admin\AdminController;
use App\Containers\Admin\Entity\Materials;
use Rudra\Container\Interfaces\RudraInterface;
use Rudra\Container\Interfaces\RequestInterface;

class MaterialsController extends AdminController
{
    #[Routing(url: 'admin', method: 'GET')]
    #[Routing(url: 'admin/materials', method: 'GET')]
    #[Routing(url: 'admin/materials/:page', method: 'GET')]
    public function materials(Materials $materials, string $page = '1'): void
    {
        $pagination = new Pagination($page, 5, $materials->numRows());
        $paginated  = $materials->getAllPerPage($pagination);

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
    public function create(RequestInterface $request, Materials $materials): void
    {
        $materials->createMaterial($this->translit($request->post()->get('title')));
    }

    #[Routing(url: 'admin/material/edit/:slug')]
    public function edit(RequestInterface $request, Materials $materials, string $slug): void
    {
        $material = $materials->find($this->getIdFromSlug($slug));

        data([
            "title"   => $material['title'],
            "content" => view("materials/edit", [
                'material' => $material,
                'redirect' => $request->server()->get('HTTP_REFERER')
            ]),
        ]);

        render("layout", data());
    }

    #[Routing(url: 'admin/material/update/:slug', method: 'POST')]
    public function update(RequestInterface $request, Materials $materials, string $slug): void
    {
        $materials->updateMaterial($this->getIdFromSlug($slug), $this->translit($request->post()->get('title')));
    }

    #[Routing(url: 'admin/material/delete', method: 'GET')]
    public function delete(Materials $materials): void
    {
        $materials->deleteMaterial();
    }

    #[Routing(url: 'admin/material/delimg', method: 'GET')]
    public function delimg(Materials $materials): void
    {
        $materials->delImgMaterial();
    }
}
