<?php

namespace App\Containers\Admin\Models;

use Rudra\Model\Model;
use Rudra\Container\Facades\Session;
use Rudra\Container\Facades\Request;
use Rudra\Redirect\RedirectFacade as Redirect;
use Rudra\Validation\ValidationFacade as Validation;

/**
 * @see MaterialsRepository
 */
class Materials extends Model
{
    public static string $table = "materials";
    public static string $directory = __DIR__;

    public static function createMaterial(string $slug): void
    {
        $processed = self::validate($slug, Request::post()->get());
        $validated = Validation::getValidated($processed, ['csrf_field', 'redirect']);

        if (Validation::approve($processed)) {
            Materials::create($validated);
        }

        Redirect::run("admin/materials");
    }

    public static function updateMaterial(string $id, string $slug): void
    {
        $processed = self::validate($slug, Request::post()->get());
        $validated = Validation::getValidated($processed, ['csrf_field']);
        $redirect  = $validated["redirect"];
        unset($validated["redirect"]);

        Materials::update($id, $validated);
        Redirect::run($redirect, "full");
    }

    public static function deleteMaterial(): void
    {
        Materials::delete(Request::get()->get('id'));
        Redirect::run(Request::server()->get('HTTP_REFERER'), "full");
    }

    private static function validate(string $slug, array $fields): array
    {
        return [
            'csrf_field' => Validation::sanitize($fields['csrf_field'])->csrf(Session::get('csrf_token'))->run(),
            'redirect'   => Validation::sanitize($fields['redirect'])->run(),
            'title'      => Validation::sanitize($fields['title'])->run(),
            'text'       => Validation::sanitize($fields['text'])->run(),
            'slug'       => Validation::sanitize($slug)->run(),
        ];
    }
} 
