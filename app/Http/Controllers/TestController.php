<?php

namespace App\Http\Controllers;

use Imagick;
use App\Jobs\TestJob;
use App\Helpers\Helpers;
use Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Models\TradeLicenseDocument;
use App\Jobs\TradeLicenseExpiringJob;
use App\Models\TradeLicenseApplication;
use Spatie\Permission\Models\Permission;

class TestController extends Controller
{
    public function index(){
        // $rolePermissions = [
        //     'trade-license-assistant' => [
        //         'approve-pending-trade-license-assistant-renewal-approval-applications',
        //         'deny-pending-trade-license-assistant-renewal-approval-applications'
        //     ],
        //     'trade-license-inspector' => [
        //         'approve-pending-trade-license-inspector-renewal-approval-applications',
        //         'deny-pending-trade-license-inspector-renewal-approval-applications'
        //     ],
        //     'trade-license-superintendent' => [
        //         'verify-license-renewal-fee-payment',
        //         'deny-license-renewal-fee-payment',
        //         'approve-pending-trade-license-superintendent-renewal-approval-applications',
        //         'deny-pending-trade-license-superintendent-renewal-approval-applications'
        //     ],
        //     'revenue-officer' => [
        //         'approve-pending-revenue-officer-renewal-approval-applications',
        //         'deny-pending-revenue-officer-renewal-approval-applications',
        //         'issue-renewed-trade-license'
        //     ],
        // ];

        // foreach ($rolePermissions as $role => $permissions) {
        //     $role = Role::where('name', $role)->first();

        //     foreach ($permissions as $permission) {
        //         Permission::create([
        //             'name' => $permission,
        //             'guard_name' => 'admin'
        //         ]);

        //         $role->givePermissionTo($permission);
        //     }
        // }

        $tla = TradeLicenseApplication::find(1);

        dd(Helpers::getFiscalYear(date('Y-m-d')) - 1 .'-' . Helpers::getFiscalYear(date('Y-m-d')),);
        

        return view('test');
    }

    public function store(){
        $file = request()->file('pdf_file');
    }

    public function optimizeWithGhostScript($inputPath, $outputPath){
        $command = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/ebook -dNOPAUSE -dQUIET -dBATCH -sOutputFile=D:\\Web_Projects\\html\\Officials\\Backend\\Laravel\\v11\\e-trade-license\\output.pdf D:\\Web_Projects\\html\\Officials\\Backend\\Laravel\\v11\\e-trade-license\\input.pdf";
        
        $commandRes = exec($command);

        return $commandRes;
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
