<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page;
        $posts = Post::orderByDesc('created_at')->skip(($page - 1) * 15)->take(15)->get();
        foreach ($posts as $post) {
            $post->user;
            $post->likes;
            $post->count = Post::count();
        }
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages() //발리데이션 실패 요인을 알려줌
            ], 403);
        }
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
        $post->viewers = $post->viewers + 1;
        $post->save();
        $post->comments = Comment::orderByDesc('created_at')->where('post_id', $id)->get();
        $post->likes;
        $post->user;
        foreach ($post->comments as $comment) {
            $comment->user;
        }
        return response()->json($post);
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if (Auth::guard('api')->user()->cannot('delete', $post)) {
            return response()->json([
                'status' => 'error',
                'messages' => 'PostPolicy'
            ], 403);
        }
        $post->delete();
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(),  [
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages() //발리데이션 실패 요인을 알려줌
            ], 403);
        }
        $post = Post::find($id);
        if (Auth::guard('api')->user()->cannot('edit', $post)) {
            return response()->json([
                'status' => 'error',
                'messages' => 'PostPolicy'
            ], 403);
        }
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
    }
}
