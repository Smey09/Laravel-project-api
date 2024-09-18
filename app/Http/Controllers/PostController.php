<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(20);
        $currentUser = auth()->user();
        foreach ($posts as $post) {
            //detect if the current user has liked the post
            $post->liked = $post->likes->contains('user_id', $currentUser->id);

            // Count the number of likes and comments for each post
            $post->likes_count = $post->likes->count();
            $post->comments_count = $post->comments->count();
        }
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $currentUser = auth()->user(); /// get current user logged in
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/posts');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        $data['user_id'] = $currentUser->id;
        $post = Post::create($data);
        return response()->json($post);
    }
    public function update(Request $request, $id)
    {
        $post = Post::find($id); // get single post
        $currentUser = auth()->user(); /// get current user logged in

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        if ($post->user_id != $currentUser->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        // continue with the update
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/posts');
            $image->move($destinationPath, $name);
            $data['image'] = $name;

            $oldImage = public_path('/posts/') . $post->image;
            if (file_exists($oldImage)) {
                @unlink($oldImage);
            }
        }
        $post->update($data);
        return response()->json($post);
    }

    public function destroy($id)
    {
        $currentUser = auth()->user(); /// get current user logged in
        $post = Post::find($id); // if post exists
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        if ($post->user_id != $currentUser->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
