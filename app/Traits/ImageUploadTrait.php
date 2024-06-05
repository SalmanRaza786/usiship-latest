<?php


namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    public function uploadImage($image, $folder)
    {
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs($folder, $fileName, 'public');
        return $fileName;
    }
}
