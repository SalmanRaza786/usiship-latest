<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

trait HandleFiles
{


    public function handleFiles( $file, $path ) : string
    {

    if ($file)  {
        $thumbnailPath = $path.'thumbnail/';
        $uniqueid = uniqid();
        $extension = $file->getClientOriginalExtension();
        $filename =$path.$uniqueid.'.'.$extension;

        $file->move(public_path('storage/uploads/'.$path), $filename);

        return  $filename;
    }


    }
}
?>
