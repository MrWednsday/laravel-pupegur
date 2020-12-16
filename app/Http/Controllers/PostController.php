<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\Image;
use App\Rules\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{

    protected $STORAGE_IMAGE_PATH = 'public/images/';
    
    /**
     * Returns a view with all posts
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->tag !== null){
            $tag = $request->tag;
            $posts = Post::with('Tags')->whereHas('Tags', function($q) use($tag){
                $q->where('tag', $tag);
            })->paginate(10);
            $posts;
        }else{
        //Show ten posts per page
            $posts = Post::latest()->paginate(10);
        }
        return view('posts.index', 
        [
            'posts' => $posts, 
        ]);
    }

    /**
     * Shows specified post by id
     *
     * @param  id  $post id 
     * @return View
     */
    public function show($id)
    {
        return view('posts.show', 
            [
                'post' => Post::findOrFail($id),
                'auth_user' => Auth::user()
            ]);
    }

    /**
     * Displayes view to create posts 
     *
     * @return View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Api method to store post
     * requires Base64 of image
     * requires text for title
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apiStore(Request $request)
    {   
        //Validaet that data is present
        //Validate image type after data decoding
        $request->validate([
            'post_title' => 'required|min:1|max:255',
            'image_data' => ['required', new PostImage()],
            'tags' => 'sometimes|array',
            'tags.*' => 'string|max:25'
        ]);

        //Regex patter to remove data type tag
        $pattern = "/data:\w{0,}\/\w{0,};base64/";
        $removeType = preg_replace($pattern, '', $request->input('image_data'));
        //Decode image
        $image = base64_decode($removeType);

        //Get data type 
        $f = finfo_open();
        $fileType = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
        $fileExtension = explode("/", $fileType)[1];
        
        //Create a safe and unique name for file in database
        $safeName = Str::random(15).'.'.$fileExtension;
        while(Image::where('path', '=', $safeName)->exists()){
            $safeName = Str::random(15).'.'.$fileExtension;
        }

        //Save image in storage
        Storage::put($this->STORAGE_IMAGE_PATH . $safeName, $image);

        //Create and safe new post
        $post = new Post;
        $post->title = $request->post_title;
        $post->user_id = $request->user('api')->id;
        $post->save();

        //Create new image
        $image = Image::create([
            'path' => $safeName,
            'imageable_type' => 'Post',
            'imageable_id' => $post->id,
        ]);

        $post->image()->save($image);

        //For each track
        foreach($request->tags as $tagText){
            //If tag dosent exits 
            //Create it
            if(! Tag::where('tag', '=', $tagText)->exists()){
                $tag = Tag::create([
                    'tag' => $tagText
                ]);
                $post->tags()->attach($tag);
            }
        }

        //Return response
        return response()->json([
            'url' => route('post.show', ['id' => $post->id]),
            'message' => 'Post Created',
        ]);
    }

    /**
     * Remove post by its id
     *
     * @param  postId  $request
     * @return \Illuminate\Http\Response
     */
    public function apiDelete($postId)
    {
        //Get post
        $post = Post::where('id', '=', $postId)->first();
        
        //If user has permison 
        //Delete post 
        //Delete file assosiated with the post
        //Respond with redirect url to user profile
        if (Gate::allows('post-delete', $post)) {
            $postUserId = $post->user_id;
            Storage::delete('public/images/' . $post->image->path);
            $post->image->delete();
            $post->delete();
            return response()->json([
                'url' => route('user.show', ['id' => $postUserId]),
                'message' => 'Post Deleted',
            ]);
        }else{
            return response('Access Denided', 401)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function apiUpdate(Request $request)
    {
        //Validate Request
        $request->validate([
            'post_title' => 'required|min:1|max:255'
        ]);

        //Get post
        $post = Post::where('id', '=', $request->post_id)->first();
        
        //If user has permison 
        //Delete update title
        if (Gate::allows('post-update', $post)) {
            $post->title = $request->post_title;
            $post->save();
            return response('Update Succesful', 202)
            ->header('Content-Type', 'text/plain');
        }else{
            return response('Access Denided', 401)
                ->header('Content-Type', 'text/plain');
        }
    }
}
