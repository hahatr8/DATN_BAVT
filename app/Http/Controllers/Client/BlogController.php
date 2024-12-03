<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    const PATH_VIEW = 'client.aboutblog.';

    public function blog()
    {
        //getAll category
        $categories = Category::query()->latest('id')->paginate(5);

        //getAll blog
        $blogs = Blog::query()->latest('id')->where('status', 1)->paginate(5);

        //getAll blog đăng mới nhất
        $newBlogs = Blog::query()->latest('created_at')->paginate(5);

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'blogs', 'newBlogs'));
    }
    
    public function blogDetail(Blog $blog)
    {
        $categories = Category::query()->latest('id')->paginate(5);

        $newBlogs = Blog::query()->latest('created_at')->where('status', 1)->paginate(5);

        $comment = Blog::with(['comments.user'])->find($blog);
        $comments = $blog->comments;

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'blog', 'newBlogs', 'comments'));
    }
}
