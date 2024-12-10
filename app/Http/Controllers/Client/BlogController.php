<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\CommentRequest;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Category;
// use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{

    const PATH_VIEW = 'client.aboutblog.';

    public function blog()
    {
        //getAll category
        $categories = Category::query()
            ->where('status', 1)
            ->orderBy('display_order', 'asc')
            ->latest('id')
            ->paginate(5);


        //getAll blog
        $blogs = Blog::query()->latest('id')->where('status', 1)->paginate(5);

        //getAll blog đăng mới nhất
        $newBlogs = Blog::query()->latest('created_at')->paginate(5);

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'blogs', 'newBlogs'));
    }

    public function blogDetail(Blog $blog)
    {

        $categories = Category::query()
            ->where('status', 1)
            ->orderBy('display_order', 'asc')
            ->latest('id')
            ->paginate(5);


        $newBlogs = Blog::query()->latest('created_at')->where('status', 1)->paginate(5);

        $comment = Blog::with(['comments.user'])->find($blog);
        $comments = $blog->comments;

        return view(self::PATH_VIEW . __FUNCTION__, compact('blog', 'categories', 'newBlogs', 'comments'));
    }
    // public function showBlog($id)
    // {
    //     $blog = Blog::with('comments.user')->findOrFail($id); // Lấy blog và kèm theo bình luận, thông qua quan hệ
    //     $comments = $blog->comments()->whereNull('parent_id')->get(); // Lấy các comment cha (không phải trả lời)

    //     return view('blogs.show', compact('blog', 'comments'));
    // }
    public function post_comment($blogID)
    {
        // Lấy dữ liệu từ request
        $data = request()->validate([
            'content' => 'required|string', // Nội dung bình luận là bắt buộc
        ]);

        // Gán thêm các giá trị cho dữ liệu
        $data['blog_id'] = $blogID;
        $data['user_id'] = auth()->id();
        $data['status'] = false; // Mặc định status là false

        // Lưu bình luận vào database
        Comment::create($data);

        // Trả về phản hồi hoặc điều hướng
        return redirect()->route('client.blogDetail', $blogID)->with('success', 'Comment added successfully.');
        // return response()->json(['message' => 'Comment posted successfully'], 201);
    }
}
