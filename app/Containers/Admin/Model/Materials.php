<?php

namespace App\Containers\Admin\Model;

use Rudra\Model\Model;
use Rudra\Model\Repository;
use Rudra\Container\Facades\Rudra;
use Rudra\Container\Facades\Session;
use Rudra\Container\Facades\Request;
use Rudra\Redirect\RedirectFacade as Redirect;
use Rudra\Validation\ValidationFacade as Validation;

/**
 * @see Repository
 *
 * @method find($id)
 * @method delete($get)
 * @method create(array $validated)
 * @method update(string $id, array $validated)
 */
class Materials extends Model
{
    public function createMaterial(string $slug): void
    {
        $imgName      = '';
        $uploadedFile = Request::files()->get("file");

        if (!empty($uploadedFile['tmp_name'])) {
            $imgName = time() . '_' . basename($uploadedFile['name']);
            $GDimage = $this->createGDimage(exif_imagetype($uploadedFile['tmp_name']), $uploadedFile['tmp_name']);

            $this->addImages($uploadedFile, $imgName, $GDimage);
        }

        $processed = $this->validate(['slug' => $slug,'image' => $imgName], (array) Request::post()->get());
        $validated = Validation::getValidated($processed, ['csrf_field', 'redirect']);

        if (Validation::approve($processed)) {
            $this->create($validated);
        }

        Redirect::run("admin/materials");
    }

    public function updateMaterial(string $id, string $slug): void
    {
        $uploadedFile = Request::files()->get("file");
        $oldImage     = Request::post()->get("image");

        if (!empty($uploadedFile['tmp_name'])) {
            $imgName = time() . '_' . basename($uploadedFile['name']);
            $GDimage = $this->createGDimage(exif_imagetype($uploadedFile['tmp_name']), $uploadedFile['tmp_name']);

            $this->addImages($uploadedFile, $imgName, $GDimage);
            $this->delImages($oldImage);
        } else {
            $imgName = $oldImage;
        }

        $processed = self::validate(['slug' => $slug,'image' => $imgName], (array) Request::post()->get());
        $validated = Validation::getValidated($processed, ['csrf_field']);
        $redirect  = $validated["redirect"];
        unset($validated["redirect"]);
        $validated["id"] = $id;

        $this->update($validated);
        Redirect::run($redirect, "full");
    }

    public function deleteMaterial(): void
    {
        $material = $this->find(Request::get()->get('id'));

        $this->delImages($material['image']);
        $this->delete(Request::get()->get('id'));
        Redirect::run(Request::server()->get('HTTP_REFERER'), "full");
    }

    public function delImgMaterial(): void
    {
        $id        = Request::get()->get('id');
        $material  = $this->find($id);

        $this->update(['id' => $id, 'image' => '']);
        $this->delImages($material['image']);
        Redirect::run(Request::server()->get('HTTP_REFERER'), "full");
    }

    private function validate(array $additional, array $fields): array
    {
        return [
            'title'      => Validation::sanitize($fields['title'])->run(),
            'slug'       => Validation::sanitize($additional['slug'])->run(),
            'redirect'   => Validation::sanitize($fields['redirect'])->run(),
            'image'      => Validation::sanitize($additional['image'])->run(),
            'text'       => Validation::set(htmlspecialchars($fields['text']))->run(),
            'csrf_field' => Validation::sanitize($fields['csrf_field'])->csrf(Session::get('csrf_token'))->run(),
        ];
    }

    private function createGDimage($type, $file)
    {
        return match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($file),
            IMAGETYPE_PNG  => imagecreatefrompng($file),
            IMAGETYPE_GIF  => imagecreatefromgif($file),
            default        => false,
        };
    }

    private function removeImg(string $imgLink): void
    {
        if (file_exists($imgLink)) {
            unlink($imgLink);
        }
    }

    private function addImages(array $uploadedFile, string $imgName, \GdImage $GDimage): void
    {
        if (move_uploaded_file($uploadedFile['tmp_name'], config('admin', 'images_path') . $imgName)) {
            $imgResized = imagescale($GDimage, config('admin', 'thumb_width'));
            imagejpeg($imgResized, config('admin', 'images_path') . 'thumb/' . $imgName);
        }
    }

    private function delImages(string $imgName): void
    {
        if(!empty($imgName)) {
            $this->removeImg(config('admin', 'images_path') . $imgName);
            $this->removeImg(config('admin', 'images_path') . 'thumb/' . $imgName);
        }
    }
}
