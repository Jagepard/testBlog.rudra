<?php

namespace App\Containers\Blog;

use App\Ship\ShipController;
use App\Ship\Utils\HelperTrait;
use Rudra\View\ViewFacade as View;

class BlogController extends ShipController
{
    use HelperTrait;

    public function containerInit()
    {
        View::setup(dirname(__DIR__) . '/', "Blog/UI/tmpl", "Blog/UI/cache");

        data([
            "title" => 'TestBlog: ',
        ]);

        $this->info(get_called_class());
    }
}