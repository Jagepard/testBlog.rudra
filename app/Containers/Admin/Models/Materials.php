<?php

namespace App\Containers\Admin\Models;

use Rudra\Container\Facades\Request;
use Rudra\Container\Facades\Rudra;
use Rudra\Container\Facades\Session;
use Rudra\Model\Model;
use Rudra\Redirect\RedirectFacade as Redirect;
use Rudra\Validation\ValidationFacade as Validation;

/**
 * @see MaterialsRepository
 */
class Materials extends Model
{
    public static string $table     = "materials";
    public static string $directory = __DIR__;

    public static function createMaterial(string $slug): void
    {
        $imgName = '';

        if (!empty(Request::files()->get("file")['tmp_name'])) {
            $image     = self::imageCreate(exif_imagetype(Request::files()->get("file")['tmp_name']), Request::files()->get("file")['tmp_name']);
            $uploadDir = Rudra::config()->get('app.path') . "/public/images/";

            if ($image) {
                $imgName = time() . '_' . basename(Request::files()->get("file")['name']);

                if (move_uploaded_file(Request::files()->get("file")['tmp_name'], $uploadDir . $imgName)) {
                    $imgResized = imagescale($image, 50);
                    imagejpeg($imgResized, $uploadDir . 'thumb/' . $imgName);
                }
            }
        }

        $processed = self::validate(['slug' => $slug,'image' => $imgName], Request::post()->get());
        $validated = Validation::getValidated($processed, ['csrf_field', 'redirect']);

        if (Validation::approve($processed)) {
            Materials::create($validated);
        }

        Redirect::run("admin/materials");
    }

    public static function updateMaterial(string $id, string $slug): void
    {
        $imgName = '';

        if (!empty(Request::files()->get("file")['tmp_name'])) {
            $image     = self::imageCreate(exif_imagetype(Request::files()->get("file")['tmp_name']), Request::files()->get("file")['tmp_name']);
            $uploadDir = Rudra::config()->get('app.path') . "/public/images/";

            if ($image) {
                $imgName = time() . '_' . basename(Request::files()->get("file")['name']);
    
                if (move_uploaded_file(Request::files()->get("file")['tmp_name'], $uploadDir . $imgName)) {
                    $imgResized = imagescale($image, 50);
                    imagejpeg($imgResized, $uploadDir . 'thumb/' . $imgName);
                }
            }

            $oldImage = Request::post()->get("image");

            if (!empty($oldImage)) {
                self::removeImg($uploadDir . $oldImage);
                self::removeImg($uploadDir . 'thumb/' . $oldImage);
            }
        } else {
            $imgName = Request::post()->get("image");
        }

        $processed = self::validate(['slug' => $slug,'image' => $imgName], Request::post()->get());
        $validated = Validation::getValidated($processed, ['csrf_field']);
        $redirect  = $validated["redirect"];
        unset($validated["redirect"]);

        Materials::update($id, $validated);
        Redirect::run($redirect, "full");
    }

    public static function deleteMaterial(): void
    {
        $material = Materials::find(Request::get()->get('id'));

        if(!empty($material['image'])) {
            $uploadDir = Rudra::config()->get('app.path') . "/public/images/";
            self::removeImg($uploadDir . $material['image']);
            self::removeImg($uploadDir . 'thumb/' . $material['image']);
        }

        Materials::delete(Request::get()->get('id'));
        Redirect::run(Request::server()->get('HTTP_REFERER'), "full");
    }

    public static function delImgMaterial(): void
    {
        $id        = Request::get()->get('id');
        $material  = Materials::find($id);
        $uploadDir = Rudra::config()->get('app.path') . "/public/images/";

        Materials::update($id, ['image' => '']);
        self::removeImg($uploadDir . $material['image']);
        self::removeImg($uploadDir . 'thumb/' . $material['image']);
        Redirect::run(Request::server()->get('HTTP_REFERER'), "full");
    }

    private static function validate(array $additional, array $fields): array
    {
        return [
            'csrf_field' => Validation::sanitize($fields['csrf_field'])->csrf(Session::get('csrf_token'))->run(),
            'redirect'   => Validation::sanitize($fields['redirect'])->run(),
            'title'      => Validation::sanitize($fields['title'])->run(),
            'text'       => Validation::set(htmlspecialchars($fields['text']))->run(),
            'slug'       => Validation::sanitize($additional['slug'])->run(),
            'image'      => Validation::sanitize($additional['image'])->run(),
        ];
    }

    private static function imageCreate($type, $file)
    {
        switch ($type) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                return imagecreatefrompng($file);
                break;
            case IMAGETYPE_GIF:
                return imagecreatefromgif($file);
                break;
            default:
                return false;
        }
    }

    private static function removeImg(string $imgLink): void
    {
        if (file_exists($imgLink)) {
            unlink($imgLink);
        }
    }
}
