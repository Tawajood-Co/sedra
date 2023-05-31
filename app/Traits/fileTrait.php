<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait fileTrait
{
    function MoveImage($request_file,$public_path)
    {
        // This is Image Information ...
        $file = $request_file;
        $ext = $file->getClientOriginalExtension();
        // $size = $file->getSize();
        // Move Image To Folder ..
        $fileNewName = 'file_' . time() . '.' . $ext;
        $file->move(public_path($public_path), $fileNewName);
        return $fileNewName;
    }


    function uploadImage($photo_name, $folder)
    {
        if($photo_name){
            $image = $photo_name;
            $image_name = time() . '' . $image->getClientOriginalName();
            $destinationPath = public_path($folder);
            $image->move($destinationPath, $image_name);
            return $image_name;
        }

    }

    function deleteFile($photo_name, $folder)
    {
        $image_name = $photo_name;
        $image_path = public_path($folder) . $image_name;
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
    }

} // end of fileTrait
