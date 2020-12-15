<?php

namespace App\Http\Controllers;

use App\Image;
use App\Rules\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    protected $STORAGE_IMAGE_PATH = 'public/images/';

    public function apiPostImage(Request $request)
    {
        //Validaet that data is present
        //Validate image type after data decoding
        $request->validate([
            'image' => ['required', new PostImage()],
        ]);

        $image = $request->user('api')->image;
        
        if (Gate::allows('profile-image-update', $image)) {
            
            //Regex patter to remove data type tag
            $pattern = "/data:\w{0,}\/\w{0,};base64/";
            $removeType = preg_replace($pattern, '', $request->input('image'));
            //Decode image
            $imageFile = base64_decode($removeType);

            //Get data type 
            $f = finfo_open();
            $fileType = finfo_buffer($f, $imageFile, FILEINFO_MIME_TYPE);
            $fileExtension = explode("/", $fileType)[1];
            
            //Create a safe and unique name for file in database
            $safeName = 'profile/' . Str::random(15).'.'.$fileExtension;
            while(Image::where('path', '=', $safeName)->exists()){
                $safeName = 'profile/' . Str::random(15).'.'.$fileExtension;
            }

            //Save image in storage
            Storage::put($this->STORAGE_IMAGE_PATH . $safeName, $imageFile);

            $image->path = $safeName;

            $image->save();

            //Return response
            return response('Update Success', 202)
                ->header('Content-Type', 'text/plain');

        }else{
            return response('Access Denided', 401)
                ->header('Content-Type', 'text/plain');
        }
    }
}
