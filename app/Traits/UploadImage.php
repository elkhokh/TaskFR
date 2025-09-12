<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadImage
{
    //store image
    public function storeImage( $image ,string $path='posts' ){
           // image - upload image in storage - save to var
                $fileName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
                $url = Storage::disk("public")->putFileAs($path, $image, $fileName);
                return $url ;
    }

    //update image
    public function updateImage($image, $oldImage = null, string $path = 'posts')  
    {  
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {  
            Storage::disk('public')->delete($oldImage);  
        }  

        return $this->storeImage($image, $path);  
    } 


    public function deleteImage($imagePath)  
    {  
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {  
            Storage::disk('public')->delete($imagePath);  
        }  
    }  
}
