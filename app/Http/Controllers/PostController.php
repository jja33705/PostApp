<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderByDesc('created_at')->get();
        foreach ($posts as $post) {
            $post->userName = $post->user->name;
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
}
