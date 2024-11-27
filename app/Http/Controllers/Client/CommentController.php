<?php

namespace App\Http\Controllers\Client;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index()
    {
        // Lấy tất cả bình luận có trạng thái status
        $comments = Comment::with('comment')->where('status', true)->get();

        // Trả về view và truyền trang bình luận
        return view('user.comments.index', compact('comments'));
    }
    
}
