<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    // Lưu bình luận mới
    public function store(CommentRequest $request)
    {
        // Lưu dữ liệu bình luận
        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'blog_id' => $request->blog_id,
            'status' => $request->status ?? false,
        ]);

        return back()->with('success', 'Thêm bình luận thành công.');
    }

    // Danh sách bình luận
    public function index()
    {
        $comments = Comment::whereNull('deleted_at')->paginate(10);
        $totalComments = Comment::whereNull('deleted_at')->count();
        $trashedComments = Comment::onlyTrashed()->count();

        return view('admin.comments.index', compact('comments', 'totalComments', 'trashedComments'));
    }

    // Danh sách bình luận trong thùng rác
    public function trash()
    {
        $title = 'Thùng rác Comment';
        $trashedComments = Comment::onlyTrashed()->paginate(10);
        $totalTrashedComments = Comment::onlyTrashed()->count();

        return view('admin.comments.trash', compact('title', 'trashedComments', 'totalTrashedComments'));
    }

    // Phục hồi bình luận từ thùng rác
    public function restore($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return back()->with('success', 'Khôi phục bình luận thành công.');
    }

    // Cập nhật bình luận
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return back()->with('success', 'Cập nhật bình luận thành công.');
    }

    // Xóa mềm bình luận
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Xóa bình luận thành công.');
    }
}
