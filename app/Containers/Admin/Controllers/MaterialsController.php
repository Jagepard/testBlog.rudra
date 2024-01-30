<?php

namespace App\Containers\Admin\Controllers;

use App\Containers\Admin\AdminController;
use App\Containers\Admin\Models\Materials;
use Rudra\Container\Facades\Request;

class MaterialsController extends AdminController
{
    ##### Чтение\ #####

    #[Routing(url: 'admin/materials', method: 'GET')]
    public function materials()
    {
        data([
            "title"   => "title",
            "content" => view("materials/index", [
                'materials' => Materials::getAll(),
            ]),
        ]);

        render("layout", data());
    }

    ##### Создание #####

    #[Routing(url: 'admin/material/add')]
    public function add()
    {
        data([
            "title"   => 'Добавить',
            "content" => view("materials/add")
        ]);

        render("layout", data());
    }

    #[Routing(url: 'admin/material/create', method: 'POST')]
    public function create()
    {
        Materials::createMaterial($this->translit(Request::post()->get('title')));
    }

    ##### \Создание #####

    ##### Обновление #####

    #[Routing(url: 'admin/material/edit/{slug}')]
    public function edit(string $slug)
    {
        $material = Materials::find($this->getIdFromSlug($slug));

        data([
            "title"   => $material['title'],
            "content" => view("materials/edit", [
                'material' => $material,
            ]),
        ]);

        render("layout", data());
    }

    #[Routing(url: 'admin/material/update/{slug}', method: 'POST')]
    public function update(string $slug)
    {
        Materials::updateMaterial($this->getIdFromSlug($slug), $this->translit(Request::post()->get('title')));
    }

    ##### \Обновление #####

    ##### Удаление\ #####

    #[Routing(url: 'admin/material/delete', method: 'GET')]
    public function delete()
    {
        Materials::deleteMaterial();
    }
}
