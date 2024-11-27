<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\CommentRequest;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{

    const PATH_VIEW = 'client.aboutblog.';

    public function blog()
    {
        //getAll category
        $categories = Category::query()->latest('id')->paginate(5);

        //getAll blog
        $blogs = Blog::query()->latest('id')->paginate(5);

        //getAll blog đăng mới nhất
        $newBlogs = Blog::query()->latest('created_at')->paginate(5);

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'blogs', 'newBlogs'));
    }

    public function blogDetail(Blog $blog)
    {

        $categories = Category::query()->latest('id')->paginate(5);
        $newBlogs = Blog::query()->latest('created_at')->paginate(5);


        $comment = Blog::with(['comments.user'])->find($blog);
        $comments = $blog->comments;

        return view(self::PATH_VIEW . __FUNCTION__, compact('comments','categories', 'blog', 'newBlogs'));
    }

    // public function store(Request $request, Blog $blog)
    // {
    //     // Xác thực dữ liệu
    //     $validated = $request->validate([
    //         'content' => 'required|string|max:1000',
    //     ]);

    //     // Tạo bình luận mới
    //     $blog->comments()->create([
    //         'user_id' => auth()->id(), // ID người dùng hiện tại
    //         'content' => $validated['content'],
    //     ]);

    //     // Chuyển hướng về trang chi tiết blog với thông báo thành công
    //     return redirect()->route('blog.detail', $blog->id)->with('success', 'Comment added successfully.');
    // }
        public function showBlog($id)
    {
        $blog = Blog::with('comments.user')->findOrFail($id); // Lấy blog và kèm theo bình luận, thông qua quan hệ
        $comments = $blog->comments()->whereNull('parent_id')->get(); // Lấy các comment cha (không phải trả lời)

        return view('blogs.show', compact('blog', 'comments'));
    }

}

    

