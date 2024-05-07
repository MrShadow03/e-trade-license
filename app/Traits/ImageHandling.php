<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;

trait ImageHandling {

    public function uploadImage($inputFileName, $dict, $return_default = true, $preferredName = null){
        //check if has image
        $hasImageInput = request()->hasFile($inputFileName);
        if($hasImageInput){
            //get image
            $image = request()->file($inputFileName);
            //upload image
            $path = $preferredName ? $image->storeAs($dict, $preferredName, 'public') : $image->store($dict, 'public');
            //return image path
            return $path;
        }
        //return default image path
        if($return_default){
            return $dict . '/' . 'default.png';
        }else{
            return null;
        }
    }

    public function deleteOldImage($inputFileName, $oldImage = null){
        //check if has new image or default image
        $hasImageInput = request()->hasFile($inputFileName);
        $hasImageInDatabase = $oldImage != null;
        $oldImageName = $hasImageInDatabase ? explode('/', $oldImage)[1] : null;
        $isDefaultImage = $oldImageName && strpos($oldImageName, 'default.') !== false;
        //if has new image then delete old image if not default image
        if($hasImageInput && !$isDefaultImage && $hasImageInDatabase){
            // check if the old image exists in the storage
            if(Storage::disk('public')->exists($oldImage)){
                // delete the old image
                Storage::disk('public')->delete($oldImage);
            }
        }
    }

    public function updateImage($inputFileName, $dict, $oldImage = null, $return_default = true, $preferredName = null){
        $hasImageInput = request()->hasFile($inputFileName);
        $hasImageInDatabase = $oldImage != null;
        
        // Delete the old image and upload the new one if a new image is provided
        if ($hasImageInput) {
            $this->deleteOldImage($inputFileName, $oldImage);
            return $this->uploadImage($inputFileName, $dict, $return_default, $preferredName);
        }

        // If there is no new image but an old one exists, return the old image
        if ($hasImageInDatabase) {
            return $oldImage;
        }

        // Return the default image path if no new image or old image
        if($return_default){
            return $dict . '/' . 'default.png';
        }else{
            return null;
        }
    }
}
