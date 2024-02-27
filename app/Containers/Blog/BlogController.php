<?php

namespace App\Containers\Blog;

use App\Ship\ShipController;
use App\Ship\Utils\HelperTrait;
use App\Ship\Utils\Translator;
use Rudra\View\ViewFacade as View;

class BlogController extends ShipController
{
    use HelperTrait;
    use Translator;

    public function containerInit()
    {
        View::setup(dirname(__DIR__) . '/', "Blog/UI/tmpl", "Blog/UI/cache");

        data([
            "title" => __CLASS__,
        ]);
    }
}