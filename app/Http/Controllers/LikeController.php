<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    // like dis like post 
    public function likeDisLike($postId){
        $currentUser = auth()->user(); /// get current user logged in
        $post = Post::find($postId); // get single post

        if(!$post){
            return response()->json(['message' => 'Post not found'], 404);
        }
        $like = Like::where('user_id', $currentUser->id)->where('post_id', $post->id)->first();
        if($like){
            $like->delete();
            return response()->json(['message' => 'Disliked']);
        }
        $like = new Like();
        $like->user_id = $currentUser->id;
        $like->post_id = $post->id;
        $like->save();
        return response()->json(['message' => 'Liked']);
    }

    public function show($postId){
        $post = Post::find($postId);
        if(!$post){
            return response()->json(['message' => 'Post not found'], 404);
        }
        $like = $post->likes()->with('user')->latest()->get();
        return response()->json($like);
    }
}
