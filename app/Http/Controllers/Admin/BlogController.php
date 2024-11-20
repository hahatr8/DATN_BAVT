<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    const PATH_VIEW = 'admin.blogs.';

    const PATH_UPLOAD = 'blogs.';

    public function index()
    {
        $data = Blog::whereNull('deleted_at')->latest('id')->get();

        $totalBlogs = Blog::whereNull('deleted_at')->count();
        $trashedBlogs = Blog::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'totalBlogs', 'trashedBlogs'));
    }

    public function trash()
    {
        $trashedBlogs = Blog::onlyTrashed()->get();
        $totalTrashedBlogs = Blog::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact( 'trashedBlogs', 'totalTrashedBlogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->except('img');

        if($request->hasFile('img')) {
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        Blog::query()->create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Thao tác thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->except('img');

        if($request->hasFile('img')) {
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        $currentImg = $blog->img;

        $data['status'] ??= 0;

        $blog->update($data);

        if($request->hasFile('img') && $currentImg && Storage::exists($currentImg)) {
            Storage::delete($currentImg);
        }

        return back()->with('success', 'Thao tác thành công');
    }

    /**
     * Remove the specified resource from storage.
     */

     public function softDestruction(Blog $Blog)
    {
        $Blog->delete();

        return back()->with('success', 'Thao tác thành công');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        if($blog->img && Storage::exists($blog->img)) {
            Storage::delete($blog->img);
        }

        return back()->with('success', 'Thao tác thành công');
    }

    public function restore($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        $blog->restore();

        return back()->with(['success' => 'Khôi phục sản phẩm thành công']);
    }
}
