<?php

namespace App\Ship\Utils;

use Rudra\Container\Facades\Rudra;
use Rudra\Redirect\RedirectFacade as Redirect;

trait HelperTrait
{
    public function info(string $message): void
    {
        Rudra::get("debugbar")['messages']->info($message);
    }

    protected function getIdFromSlug(string $slug): string
    {
        $slug = strip_tags($slug);

        return (strpos($slug, '_') !== false) ? strstr($slug, '_', true) : $slug;
    }

    private function handleField(string $field, string $checkBoxName)
    {
        if ($field === $checkBoxName) {
            return (Request::post()->has($field)) ? '1' : '0';
        }

        return Request::post()->get($field);
    }

    protected function handle404($data)
    {
        if (!$data) {
            Redirect::run("404");
        }
    }
}
