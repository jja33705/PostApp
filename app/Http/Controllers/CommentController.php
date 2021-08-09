<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages() //발리데이션 실패 요인을 알려줌
            ], 403);
        }
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = Auth::guard('api')->user()->id;
        $comment->post_id = $id;
        $comment->save();
    }
    public function delete($id)
    {
        $comment = Comment::find($id);
        if (Auth::guard('api')->user()->cannot('delete', $comment)) {
            return response()->json([
                'status' => 'error',
                'messages' => 'CommentPolicy'
            ], 403);
        }
        $comment->delete();
    }
}
