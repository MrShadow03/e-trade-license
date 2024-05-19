<?php

namespace App\Http\Controllers;

use Imagick;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\TradeLicenseDocument;
use App\Models\TradeLicenseApplication;
use Spatie\Permission\Models\Permission;

class TestController extends Controller
{
    public function store(){
        // $tl = TradeLicenseDocument::find(22);

        // $tl->media->each(function($media){
        //     if($media->id >= 37 && $media->id <= 51){
        //         $media->delete();
        //     }
        // });

        dd(Helpers::numToBanglaWords('23465412'));

        return response()->json(['message' => 'Success']);
    }

    public static function resizeImage($inputFileName = 'image', $width = 300, $preserveAspectRatio = false) {
        // Get the uploaded file
        $uploadedFile = request()->file($inputFileName);

        // Load the uploaded image
        $originalImage = imagecreatefromstring(file_get_contents($uploadedFile->getPathname()));

        // Get the original image dimensions
        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        if($preserveAspectRatio){
            $aspectRatio = $originalWidth / $originalHeight;
            $newWidth = $width;
            $newHeight = $width / $aspectRatio;

            // Create a new blank image with the new dimensions (Cropped to square)
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Crop and resize the original image to fit the new dimensions
            imagecopyresampled(
                $resizedImage, // Destination image resource
                $originalImage, // Source image resource
                0, // Destination x-coordinate
                0, // Destination y-coordinate
                0, // Source x-coordinate (cropping)
                0, // Source y-coordinate (cropping)
                $newWidth, // Destination width
                $newHeight, // Destination height
                $originalWidth, // Source width (cropping)
                $originalHeight // Source height (cropping)
            );
        }else {
            $minDimension = min($originalWidth, $originalHeight);
    
            // Calculate the new dimensions for the square image
            $newWidth = $newHeight = $width;

            // Calculate the cropping coordinates
            $cropX = ($originalWidth - $minDimension) / 2;
            $cropY = 0; // Top the cropping area

            // Create a new blank image with the new dimensions (Cropped to square)
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Crop and resize the original image to fit the new dimensions
            imagecopyresampled(
                $resizedImage, // Destination image resource
                $originalImage, // Source image resource
                0, // Destination x-coordinate
                0, // Destination y-coordinate
                $cropX, // Source x-coordinate (cropping)
                $cropY, // Source y-coordinate (cropping)
                $newWidth, // Destination width
                $newHeight, // Destination height
                $minDimension, // Source width (cropping)
                $minDimension // Source height (cropping)
            );
        }

        // Save the resized image to a new file
        $resizedImagePath = $uploadedFile->store('images', 'public');
        imagejpeg($resizedImage, storage_path('app/public/' . $resizedImagePath));

        // Free up memory by destroying the image resources
        imagedestroy($originalImage);
        imagedestroy($resizedImage);

        return storage_path('app/public/' . $resizedImagePath);
    }
}
