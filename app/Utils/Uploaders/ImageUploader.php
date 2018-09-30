<?php
namespace App\Utils\Uploaders;

use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Image;

class ImageUploader
{

    public static function upload($uploadImage, $path, $scale = [])
    {
        Image::make($uploadImage);

        $now = Carbon::now();

        $imageName = $now->timestamp . '.' . $uploadImage->getClientOriginalExtension();

        $smallWidth = $scale['small']['width'] ?? 150;
        $smallHeight = $scale['small']['height'] ?? 100;

        $smallImage = Image::make($uploadImage);
        $smallImage->resize($smallWidth, $smallHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $smallImage->save(public_path($path . "small/" . $imageName), 80);

        $largeWidth = $scale['large']['width'] ?? 600;
        $largeHeight = $scale['large']['height'] ?? 195;

        $largeImage = Image::make($uploadImage);
        $largeImage->resize($largeWidth, $largeHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $largeImage->save(public_path($path . "large/" . $imageName), 100);

        return $imageName;
    }


}
