<?php

namespace App;

use App\User;
use App\Post;
use App\Image;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DailyDogPicture
{
    private $apiUrl;
    private $apiKey;
    private $STORAGE_IMAGE_PATH = 'public/images/';

    public function __construct($url, $key) {
        $this->apiUrl = $url;
        $this->apiKey = $key;
    }

    public function getDailyDogPicture() {
        // Get all post for user account
        $posts = Post::where('user_id', '=', '1')->orderBy('created_at')->get();

        //
        if($posts->count() !== 0){

        }else if($posts->count() === 0){
            $post = $this->createNewDailyDogPost();
            return view('posts.show', 
            [
                'post' => $post,
                'auth_user' => Auth::user()
            ]);
        }else{
            return '500 Internal Error';
        }
    }
    private function createNewDailyDogPost() {
        $user = User::where('id',  1)->first();

        $data = $this->callApi();
        $json = json_decode($data->getBody()->getContents());
        $fileName = $this->downloadImage($json[0]->url);
        $image = $this->createImage($fileName);
        $post = $this->createPost($user);
        $post->image()->save($image);
        
        return $post;
    }

    private function getTag() {
        return Tag::where('tag',  'Daily Pup')
    }

    private function createPost(User $user) {
        $post = new Post;
        $post->title = 'Daily Pup Image';
        $post->user_id = $user->id;
        $post->save();
        return $post;
    }

    private function createImage($fileName) {
        return Image::create([
            'path' => $fileName,
        ]);
    }

    private function downloadImage($url){
        $imageFile = file_get_contents($url);
        $fileName = $this->createName($url);
        Storage::put($this->STORAGE_IMAGE_PATH . $fileName, $imageFile);
        return $fileName;
    }

    private function createName($url){
        
        $fileExtension = $this->getFileExtension($url);

        $safeName = Str::random(15).'.'.$fileExtension;
        while(Image::where('path', '=', $safeName)->exists()){
            $safeName = Str::random(15).'.'.$fileExtension;
        }
        return $safeName;
    }
    private function getFileExtension($url){
        $splitString = explode('.', $url);
        return end($splitString);
    }
    private function callApi(){
         return Http::get($this->apiUrl, [
            'x-api-key' => $this->apiKey
         ]);
    }
}
