<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    //
    public static function resizeImage($project_folder){

        $directoryPath = storage_path().'/raw_images/'.$project_folder;
        $validExtensions = ['jpg', 'jpeg', 'png'];
        $allFiles = collect(File::allFiles($directoryPath));
        $imageFiles = $allFiles->filter(function ($file) use ($validExtensions) {
            $extension = strtolower($file->getExtension());
            return in_array($extension, $validExtensions);
        })->all();

        foreach($imageFiles as $index=>$r_image){
            $target_path = storage_path().'/output/'.$project_folder.'/'.$r_image->getRelativePathname();
            $image = Image::make($r_image->getRealPath());
            $image->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if (!File::exists(dirname($target_path))) {
                File::makeDirectory(dirname($target_path), 0755, true, true);
            }
            $newFileName = sprintf("%s%s.%s", str_replace($r_image->getFilename(), '', $target_path),($index+1),$r_image->getExtension());
            $image->save($newFileName);
            echo "\tResizing File : " . $r_image->getRelativePathname() . PHP_EOL;
            // dd($newFileName);
        }
    }
}
