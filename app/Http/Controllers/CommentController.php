<?php

namespace App\Http\Controllers;

use App\Event\CommentReceived;
use App\Notifications\CommentPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Comment;


class CommentController extends Controller
{
    /**
     * Returns all comments for post 
     *
     * @param  postid  id of post 
     * @return \Illuminate\Http\Response returns json with all comments
     */
    public function apiIndex($post_id)
    {
        $comments = Comment::with('user')->where('post_id', '=', $post_id)->orderBy('created_at', 'desc')->get();
        return response()->json($comments);
    }

    /**
     * Creates new comment and validates it 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'comment' => 'required|max:255|min:1',
            'post_id' => 'required'
        ]);

        $comment = Comment::create([
            'user_id' => $request->user('api')->id,
            'post_id' => $request->post_id,
            'text' => $request->comment,
        ]);

        $comment->post->user->notify(new CommentPosted($comment));
        event(new CommentReceived($comment));

        if ($comment->exists() === true) {
            return response('Created Correctly', 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response('Created Incorrectly', 500)
                ->header('Content-Type', 'text/plain');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  comment id  $removes specifiec comment id
     * @return \Illuminate\Http\Response
     */

    public function delete($comment_id)
    {   
        $comment = Comment::where('id', '=', $comment_id)->first();
        if (Gate::allows('comment-delete', $comment)) {
            $comment->delete();
            return response('Comment Deleted', 200)
                  ->header('Content-Type', 'text/plain');
        }else{
            return response('Access Denided', 401)
                ->header('Content-Type', 'text/plain');
        }
    }

    /**
     * Edits a comment in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validated = $request->validate([
            'comment_text' => 'required|max:255|min:1',
            'comment_id' => 'required'
        ]);

        $comment = Comment::where('id', '=', $request->comment_id)->get()[0];
        if (Gate::allows('comment-edit', $comment)) {
            $comment->text = $request->comment_text;
            $comment->save();
            return response('Comment Eddited', 200)
                  ->header('Content-Type', 'text/plain');
        }else{
            return response('Access Denided', 401)
                ->header('Content-Type', 'text/plain');
        }
    }
}
