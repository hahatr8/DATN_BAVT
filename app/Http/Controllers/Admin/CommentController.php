<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
//     // Lưu bình luận mới
//     public function store(Request $request, Blog $blog)
// {
//     $request->validate([
//         'content' => 'required|max:500',
//     ]);

//     Comment::create([
//         'content' => $request->content,
//         'user_id' => auth()->id(),
//         'blog_id' => $blog->id,
//         'parent_id' => $request->parent_id, // Null nếu không phải trả lời
//         'status' => false, // Nếu cần duyệt
//     ]);

//     return redirect()->back()->with('success', 'Your comment has been submitted!');
// }

    public function store(Request $request, Blog $blog)
    {
        $request->validate([
            'content' => 'required|max:500',
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'blog_id' => $blog->id,
            'parent_id' => $request->parent_id, // Null nếu không phải trả lời
            'status' => false, // Nếu cần duyệt
        ]);

        return redirect()->back()->with('success', 'Your comment has been submitted!');
    }


    // Danh sách bình luận
    public function index()
    {

        $comments = Comment::whereNull('deleted_at')->with(['blogs'])->get();
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
