<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Image;

class ImageService
{
    public function uploadImage($image, $directory)
    {
        if (!File::isDirectory(public_path($directory))) {
            mkdir(public_path($directory), 0777, true);
        }

        $photo_name = Str::random(10);
        $extension = strtolower($image->getClientOriginalExtension());

        if (in_array($extension, ['jpg', 'png', 'gif', 'bmp', 'webp'])) {
            $img = Image::make($image);
            $img->encode('webp', 90)->save(public_path("$directory/$photo_name.webp"));
            $path = "/$directory/$photo_name.webp";
        } else {
            $image->move(public_path($directory), "$photo_name.$extension");
            $path = "/$directory/$photo_name.$extension";
        }

        return $path;
    }
}
