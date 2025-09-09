<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadImage
{
    public function uploadImage( $image ,string $path='posts' ){
                        // image - upload image in storage - save to var
                $fileName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
                $url = Storage::disk("public")->putFileAs($path, $image, $fileName);
                return $url ;
    }
}
