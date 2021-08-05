<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page;
        $posts = Post::orderByDesc('created_at')->skip(($page - 1) * 15)->take(15)->get();
        foreach ($posts as $post) {
            $post->user;
            $post->count = Post::count();
        }
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::guard('api')->user()->id;
        $post->save();
        return response()->json($post);
    }

    public function like($id)
    {
        $like = new Like();
        $like->user_id = Auth::guard('api')->user()->id;
        $like->post_id = $id;
        $like->save();
    }

    public function show($id)
    {
        $post = Post::find($id);
        $post->comments;
        $post->likes;
        $post->user;
        return response()->json($post);
    }

    public function delete($id)
    {
        Post::destroy($id);
    }
}
