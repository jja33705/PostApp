<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = Auth::guard('api')->user()->id;
        $comment->post_id = $id;
        $comment->save();
    }
}
