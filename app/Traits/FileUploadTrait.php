<?php


namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait FileUploadTrait
{

    public function uploadImage(Request $request, $inputName, $oldPath = NULL, $path = "/uploads")
    {


        if ($request->hasFile($inputName)) {

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;

            $image->move(public_path($path), $imageName);


            //delete previous image file if exist
            if ($oldPath && File::exists(public_path($oldPath))) {
                File::delete(public_path($oldPath));
            }


            return $path . '/' . $imageName;
        } else {
            return NULL;
        }
    }


    //delete file
    public function removeImage(string $path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
