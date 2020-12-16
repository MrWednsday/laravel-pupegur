<?php

namespace App;

use App\User;
use App\Post;

use Illuminate\Support\Facades\Http;


class DailyDogPicture
{
    private $apiUrl;
    private $apiKey;

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
            return $this->createNewDailyDogPost();
        }else{
            return '500 Internal Error';
        }
    }
    private function createNewDailyDogPost() {
        $data = $this->callApi();
        $json = json_decode($data->getBody()->getContents());
        $this->downloadImage($json[0]->url);
    }

    private function downloadImage($url){
        dd(file_get_contents($url));
    }
    private function callApi(){
         return Http::get($this->apiUrl, [
            'x-api-key' => $this->apiKey
         ]);
    }
}
