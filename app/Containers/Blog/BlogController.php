<?php

namespace App\Containers\Blog;

use App\Ship\ShipController;
use Rudra\View\ViewFacade as View;
use App\Containers\Tools\HelperTrait;
use Rudra\Controller\ContainerControllerInterface;

class BlogController extends ShipController implements ContainerControllerInterface
{
    use HelperTrait;

    public function containerInit(): void
    {
        View::setup(dirname(__DIR__) . '/', "Blog/UI/tmpl", "Blog/UI/cache");

        data([
            "title" => 'TestBlog: ',
        ]);

        $this->info(get_called_class());
    }
}
