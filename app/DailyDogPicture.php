<?php

namespace App;

use App\User;
use App\Post;
use App\Image;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DailyDogPicture
{
    // API URL
    private $apiUrl;
    // API KEY
    private $apiKey;
    //STORAGE PATH
    private $STORAGE_IMAGE_PATH = 'public/images/';

    public function __construct($url, $key) {
        $this->apiUrl = $url;
        $this->apiKey = $key;
    }

    /**
     * This function will display a post of dog
     * It will check if a new post was created in the last 24h if yes it will display it
     * If not it will comunicate with external API to download an image and display that 
     * 
     * @return View 
     */
    public function getDailyDogPicture() {
        // Get all post beloning to user_id 1 my bot
        // That were created in the last 24h
        $posts = Post::where('created_at', '>=', Carbon::now()->subDay())
            ->where('user_id', 1)->get();

        // If count is not 0
        if($posts->count() !== 0){
            // Return view with first
            return view('posts.show', 
            [
                'post' => $posts->first(),
                'auth_user' => Auth::user()
            ]);
        // Else create new post 
        // And show it
        }else if($posts->count() === 0){
            //Create new post
            $post = $this->createNewDailyDogPost();
            return view('posts.show', 
            [
                'post' => $post,
                'auth_user' => Auth::user()
            ]);
        // Crash gracefully 
        }else{
            return response('Internal Server Error', 500)
                ->header('Content-Type', 'text/plain');
        }
    }

    /**
     * This method will creat new daily post
     * 
     * @return \App\Post
     */ 
    private function createNewDailyDogPost() {
        $user = User::where('id',  1)->first();

        $data = $this->callApi();
        $json = json_decode($data->getBody()->getContents());
        $fileName = $this->downloadImage($json[0]->url);
        $image = $this->createImage($fileName);
        $post = $this->createPost($user);
        $post->image()->save($image);

        $tag = $this->getTag();

        $post->tags()->attach($tag);
        
        return $post;
    }

    /**
     * Return tag message
     * 
     * @return Tag
     */ 
    private function getTag() {
        return Tag::where('tag',  'Daily Pup')->first();
    }

    /**
     * Creates new post and attach it to daily pup bot
     *
     * @param  \App\User
     * @return \App\Post
     */
    private function createPost(User $user) {
        $post = new Post;
        $post->title = 'Daily Pup Image';
        $post->user_id = $user->id;
        $post->save();
        return $post;
    }

    /**
     * Creates new image
     *
     * @param  String
     * @return \App\Image
     */
    private function createImage($fileName) {
        return Image::create([
            'path' => $fileName,
        ]);
    }

    /**
     * This method downloads image from URL
     *
     * @param  String url of file to downlaod 
     * @return String filename
     */
    private function downloadImage($url){
        $imageFile = file_get_contents($url);
        $fileName = $this->createName($url);
        Storage::put($this->STORAGE_IMAGE_PATH . $fileName, $imageFile);
        return $fileName;
    }

    /**
     * Create safe name that dosent appear in database
     * 
     * @param  String url of file
     * @return String filename
     */
    private function createName($url){
        // Get file extension
        $fileExtension = $this->getFileExtension($url);
        // Creat name 
        $safeName = Str::random(15).'.'.$fileExtension;
        // While name is not unique create a new one
        while(Image::where('path', '=', $safeName)->exists()){
            $safeName = Str::random(15).'.'.$fileExtension;
        }
        return $safeName;
    }

    /**
     * Extract file extension
     * 
     * @param  String url of file
     * @return String file extension
     */
    private function getFileExtension($url){
        // Split url on '.'
        $splitString = explode('.', $url);
        // Return last element
        return end($splitString);
    }

    /**
     * Calls api
     * 
     * @return \Illuminate\Http\Client\Response response from api
     */
    private function callApi(){
         return Http::get($this->apiUrl, [
            'x-api-key' => $this->apiKey
         ]);
    }
}
