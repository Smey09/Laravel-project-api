<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Validator;
class CommentController extends Controller
{
    // show user liked post by post id
    public function show($postId){
        $post = Post::find($postId);
        if(!$post){
            return response()->json(['message' => 'Post not found'], 404);
        }
        $comments = $post->comments()->with('user')->latest()->get();
        return response()->json($comments);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'post_id' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $data = $request->all();
        $currentUser = auth()->user(); /// get current user logged in
        $post = Post::find($data['post_id']);
        if(!$post){
            return response()->json(['message' => 'Post not found'], 404);
        }
        $data['user_id'] = $currentUser->id;
        $comment = $post->comments()->create($data);
        return response()->json($comment);

    }
    public function update(Request $request,$id){
        $comment = Comment::find($id); // get single comment
        $currentUser = auth()->user(); /// get current user logged in
        if(!$comment){
            return response()->json(['message' => 'Comment not found'], 404);
        }
        if($comment->user_id != $currentUser->id){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        // continue with the update
        $data = $request->all();
        $comment->update($data);
        return response()->json($comment);
    }
    public function destroy($id){
        $comment = Comment::find($id); // get single comment
        $currentUser = auth()->user(); /// get current user logged in
        if(!$comment){
            return response()->json(['message' => 'Comment not found'], 404);
        }
        if($comment->user_id != $currentUser->id){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}
