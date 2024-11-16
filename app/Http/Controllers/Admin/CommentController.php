<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function index()
    {
        $comments = Comment::all();
        return view('admin.comments.index', compact('comments'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back();
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return back();
    }
}
