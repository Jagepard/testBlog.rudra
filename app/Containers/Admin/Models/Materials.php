<?php

namespace App\Containers\Admin\Models;

use Rudra\Model\Model;
use Rudra\Container\Facades\Rudra;
use Rudra\Container\Facades\Session;
use Rudra\Container\Facades\Request;
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
        $imgName      = '';
        $uploadedFile = Request::files()->get("file");

        if (!empty($uploadedFile['tmp_name'])) {
            $imgName = time() . '_' . basename($uploadedFile['name']);
            $GDimage = Materials::createGDimage(exif_imagetype($uploadedFile['tmp_name']), $uploadedFile['tmp_name']);

            Materials::addImages($uploadedFile, $imgName, $GDimage);
        }

        $processed = Materials::validate(['slug' => $slug,'image' => $imgName], Request::post()->get());
        $validated = Validation::getValidated($processed, ['csrf_field', 'redirect']);

        if (Validation::approve($processed)) {
            Materials::create($validated);
        }

        Redirect::run("admin/materials");
    }

    public static function updateMaterial(string $id, string $slug): void
    {
        $imgName      = '';
        $uploadedFile = Request::files()->get("file");

        if (!empty($uploadedFile['tmp_name'])) {
            $imgName   = time() . '_' . basename($uploadedFile['name']);
            $GDimage   = Materials::createGDimage(exif_imagetype($uploadedFile['tmp_name']), $uploadedFile['tmp_name']);
            $oldImage  = Request::post()->get("image");

            Materials::addImages($uploadedFile, $imgName, $GDimage);
            Materials::delImages($oldImage);
        } else {
            $imgName = $oldImage;
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

        Materials::delImages($material['image']);
        Materials::delete(Request::get()->get('id'));
        Redirect::run(Request::server()->get('HTTP_REFERER'), "full");
    }

    public static function delImgMaterial(): void
    {
        $id        = Request::get()->get('id');
        $material  = Materials::find($id);
        $uploadDir = Rudra::config()->get('app.path') . "/public/images/";

        Materials::update($id, ['image' => '']);
        Materials::delImages($material['image']);
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

    private static function createGDimage($type, $file)
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

    private static function addImages(array $uploadedFile, string $imgName, \GdImage $GDimage): void
    {
        if ($GDimage) {
            if (move_uploaded_file($uploadedFile['tmp_name'], config('admin', 'images_path') . $imgName)) {
                $imgResized = imagescale($GDimage, config('admin', 'thumb_width'));
                imagejpeg($imgResized, config('admin', 'images_path') . 'thumb/' . $imgName);
            }
        }
    }

    private static function delImages(string $imgName): void
    {
        if(!empty($imgName)) {
            Materials::removeImg(config('admin', 'images_path') . $imgName);
            Materials::removeImg(config('admin', 'images_path') . 'thumb/' . $imgName);
        }
    }
}
